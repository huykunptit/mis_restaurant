<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Transaction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Màn hình thanh toán
     */
    public function table($tableId)
    {
        $table = Table::findOrFail($tableId);

        // Lấy tất cả đơn chưa thanh toán của bàn
        $orders = Transaction::with(['menu', 'menuOption'])
            ->where('table_id', $tableId)
            ->where('payment_status', 'no')
            ->get()
            ->groupBy('order_group_id');

        if ($orders->isEmpty()) {
            return redirect()->route('staff.orders.table', $tableId)
                ->with('error', 'Bàn này không có đơn hàng nào cần thanh toán');
        }

        // Tính tổng tiền
        $total = 0;
        $orderGroups = [];
        foreach ($orders as $groupId => $groupOrders) {
            $groupTotal = 0;
            foreach ($groupOrders as $order) {
                $groupTotal += ($order->menuOption->cost ?? 0) * $order->quantity;
            }
            $total += $groupTotal;
            $orderGroups[] = [
                'group_id' => $groupId,
                'orders' => $groupOrders,
                'total' => $groupTotal,
            ];
        }

        // Cho phép thanh toán sớm (không cần đợi tất cả món giao)
        // Tính số món đã giao và chưa giao
        $completedCount = 0;
        $totalCount = 0;
        foreach ($orders as $groupOrders) {
            foreach ($groupOrders as $order) {
                $totalCount++;
                if ($order->completion_status === 'yes') {
                    $completedCount++;
                }
            }
        }

        return view('staff.payment.table', compact('table', 'orderGroups', 'total', 'completedCount', 'totalCount'));
    }

    /**
     * Tạo QR Code thanh toán
     */
    public function createQrCode(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'payment_method' => 'required|in:sepay_qr,vnpay_qr,bank_transfer,cash',
            'amount' => 'required|numeric|min:1000',
            'removed_items' => 'nullable|array', // IDs của các món bị trừ
            'removed_items.*' => 'exists:transactions,id',
        ]);

        $table = Table::findOrFail($request->table_id);
        $paymentMethod = $request->payment_method;
        $amount = $request->amount;
        $removedItems = $request->removed_items ?? [];

        // Tạo order_group_id từ các đơn chưa thanh toán
        $orderGroups = Transaction::where('table_id', $table->id)
            ->where('payment_status', 'no')
            ->distinct()
            ->pluck('order_group_id')
            ->toArray();

        DB::beginTransaction();
        try {
            // Xóa các món bị trừ (nếu có)
            if (!empty($removedItems)) {
                Transaction::whereIn('id', $removedItems)
                    ->where('table_id', $table->id)
                    ->where('payment_status', 'no')
                    ->delete();
            }

            // Tạo payment record
            $payment = Payment::create([
                'table_id' => $table->id,
                'order_group_id' => implode(',', $orderGroups), // Lưu tất cả order_group_id
                'payment_method' => $paymentMethod,
                'amount' => $amount,
                'status' => 'pending',
                'payment_gateway_response' => !empty($removedItems) ? json_encode(['removed_items' => $removedItems]) : null,
            ]);

            // Generate QR Code URL (placeholder - sẽ tích hợp API thật sau)
            $qrCodeUrl = $this->generateQrCode($paymentMethod, $amount, $payment->id);

            $payment->qr_code_url = $qrCodeUrl;
            $payment->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'payment_id' => $payment->id,
                'qr_code_url' => $qrCodeUrl,
                'expires_at' => now()->addMinutes(5)->toDateTimeString(),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Xác nhận thanh toán thành công (manual confirm)
     */
    public function confirm(Request $request, $paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        if ($payment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Thanh toán này đã được xử lý');
        }

        DB::beginTransaction();
        try {
            // Cập nhật payment status
            $payment->status = 'success';
            $payment->paid_at = now();
            $payment->save();

            // Cập nhật transactions (chỉ những món còn lại, không bị trừ)
            $orderGroupIds = explode(',', $payment->order_group_id);
            $query = Transaction::whereIn('order_group_id', $orderGroupIds)
                ->where('table_id', $payment->table_id);
            
            // Nếu có removed_items, chỉ update những món không bị trừ
            if ($payment->payment_gateway_response) {
                $response = json_decode($payment->payment_gateway_response, true);
                if (isset($response['removed_items']) && !empty($response['removed_items'])) {
                    $query->whereNotIn('id', $response['removed_items']);
                }
            }
            
            $query->update(['payment_status' => 'yes']);

            // Cập nhật table status
            $table = Table::find($payment->table_id);
            if ($table) {
                // Kiểm tra xem còn đơn nào chưa thanh toán không
                $unpaidOrders = Transaction::where('table_id', $table->id)
                    ->where('payment_status', 'no')
                    ->count();

                if ($unpaidOrders === 0) {
                    $table->status = 'available';
                    $table->save();
                }
            }

            DB::commit();

            // Gửi real-time notification về admin
            $this->sendPaymentNotification($payment);
            
            // Broadcast event
            event(new \App\Events\PaymentSuccess($payment));

            return redirect()->route('staff.orders.select-table')
                ->with('success', 'Thanh toán thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    /**
     * Webhook callback từ payment gateway
     */
    public function webhook(Request $request, $gateway)
    {
        // TODO: Implement webhook handling cho Sepay và VNPay
        // Validate signature
        // Update payment status
        // Send notification

        return response()->json(['success' => true]);
    }

    /**
     * Generate QR Code URL (placeholder)
     */
    private function generateQrCode($method, $amount, $paymentId)
    {
        // Placeholder - sẽ tích hợp API thật sau
        // Sepay: https://api.sepay.vn/qr/generate
        // VNPay: https://sandbox.vnpayment.vn/paymentv2/vpcpay.html

        // Tạm thời tạo QR code bằng API công khai
        $data = [
            'amount' => $amount,
            'payment_id' => $paymentId,
            'method' => $method,
            'timestamp' => now()->timestamp,
        ];

        $qrData = json_encode($data);
        
        // Sử dụng QR code generator API công khai
        return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qrData);
    }

    /**
     * Send payment notification
     */
    private function sendPaymentNotification($payment)
    {
        $table = $payment->table;
        
        // Tạo notification cho admin
        \App\Models\Notification::create([
            'user_id' => null, // null = gửi cho tất cả admin
            'type' => 'payment_success',
            'title' => 'Thanh toán thành công',
            'message' => "Bàn {$table->table_number} ({$table->zone}) đã thanh toán " . number_format($payment->amount, 0) . " VNĐ",
            'related_type' => 'payment',
            'related_id' => $payment->id,
            'is_read' => false,
        ]);

        // Broadcast event đã được gọi ở confirm()
    }
}



