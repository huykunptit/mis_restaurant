# 📊 ĐÁNH GIÁ HỆ THỐNG & ĐỀ XUẤT CẢI TIẾN

## 🎯 MỤC TIÊU MỚI
Chuyển đổi từ mô hình **khách tự đặt món** sang mô hình **nhân viên đến tận bàn đặt món cho khách**.

---

## 📋 QUY TRÌNH MỚI

### 1. **Quy trình đặt món**
```
Khách gọi món 
  → Nhân viên chọn bàn 
  → Chọn đồ ăn 
  → Xác nhận gọi món 
  → Noti real-time về Admin
```

### 2. **Quy trình giao món & thanh toán**
```
Admin nhận đơn → Giao món → Tick "Đã giao"
  → Nhân viên nhấn "Thanh toán" 
  → Chọn phương thức (Sepay QR / VNPay / Chuyển khoản)
  → Hiển thị QR Code
  → Thanh toán thành công → Noti real-time về Admin
```

---

## 🔍 ĐÁNH GIÁ HỆ THỐNG HIỆN TẠI

### ✅ **Điểm mạnh**
1. **Database Structure**: 
   - Đã có `transactions`, `tables`, `menu_options`, `users`
   - Đã có `zone` cho bàn
   - Đã có `payment_status`, `completion_status`

2. **Order Management**:
   - Đã có quản lý đơn hàng theo bàn
   - Đã có filter theo trạng thái
   - Đã có pagination

3. **UI Components**:
   - Đã có Material Symbols icons
   - Đã có Bootstrap 5 + Tailwind CSS
   - Responsive design

### ❌ **Điểm yếu cần cải thiện**

#### 1. **Quy trình đặt món**
- ❌ Hiện tại: Khách tự đặt qua cart/checkout
- ✅ Cần: Nhân viên đặt món tại bàn cho khách
- ❌ Thiếu: Giao diện nhân viên chọn bàn → chọn món → xác nhận
- ❌ Thiếu: Real-time notification khi có đơn mới

#### 2. **Quản lý đơn hàng**
- ⚠️ Hiện tại: Quản lý theo user_id (khách hàng)
- ✅ Cần: Quản lý theo table_id (bàn) và zone (khu vực)
- ❌ Thiếu: Group orders theo bàn
- ❌ Thiếu: Hiển thị tổng tiền theo bàn
- ❌ Thiếu: Quản lý nhiều đơn trong cùng 1 bàn

#### 3. **Thanh toán**
- ❌ Hiện tại: Chỉ lưu payment_method, chưa xử lý thanh toán thực
- ✅ Cần: Tích hợp Sepay QR Code và VNPay
- ❌ Thiếu: Hiển thị QR Code
- ❌ Thiếu: Webhook callback từ payment gateway
- ❌ Thiếu: Real-time notification khi thanh toán thành công

#### 4. **Real-time Notifications**
- ❌ Chưa có: Hệ thống real-time notifications
- ✅ Cần: 
  - Noti khi có đơn mới
  - Noti khi món đã giao
  - Noti khi thanh toán thành công
- ❌ Thiếu: WebSocket/Pusher integration
- ❌ Thiếu: Notification center

#### 5. **Giao diện**
- ⚠️ Hiện tại: Giao diện cho khách tự đặt
- ✅ Cần: Giao diện cho nhân viên đặt món tại bàn
- ❌ Thiếu: Màn hình chọn bàn (table selection)
- ❌ Thiếu: Màn hình đặt món nhanh (quick order)
- ❌ Thiếu: Màn hình quản lý đơn theo bàn

---

## 🚀 ĐỀ XUẤT CẢI TIẾN

### 1. **Giao diện nhân viên đặt món** ⭐⭐⭐

#### A. Màn hình chọn bàn (Table Selection)
```
/staff/orders/create
```
**Features:**
- Hiển thị sơ đồ bàn theo khu vực (zone)
- Màu sắc trạng thái:
  - 🟢 Xanh: Trống (available)
  - 🟡 Vàng: Có khách chưa đặt món (occupied, no orders)
  - 🔴 Đỏ: Có đơn chưa thanh toán (has unpaid orders)
  - ⚪ Xám: Đã thanh toán (paid)
- Click vào bàn → Chuyển sang màn hình đặt món
- Search bàn theo số hoặc khu vực
- Filter theo zone

#### B. Màn hình đặt món (Quick Order)
```
/staff/orders/create?table_id={id}
```
**Features:**
- Header: Hiển thị thông tin bàn (Zone - Bàn số)
- Danh sách món theo category (tabs)
- Quick add: Click món → Chọn option → Thêm vào đơn
- Cart preview: Hiển thị đơn hiện tại của bàn
- Actions:
  - "Thêm món" (tiếp tục đặt)
  - "Xác nhận đặt món" (submit order)
  - "Hủy" (quay lại chọn bàn)

#### C. Màn hình quản lý đơn theo bàn
```
/staff/orders/table/{table_id}
```
**Features:**
- Hiển thị tất cả đơn của bàn
- Group theo thời gian đặt
- Trạng thái từng món: Chưa giao / Đã giao
- Tổng tiền bàn
- Actions:
  - "Giao món" (tick từng món)
  - "Thanh toán" (chỉ hiện khi tất cả món đã giao)

---

### 2. **Giao diện Admin quản lý đơn** ⭐⭐⭐

#### A. Dashboard đơn hàng
```
/admin/orders
```
**Cải tiến:**
- View theo bàn thay vì theo user
- Group orders theo table_id
- Hiển thị zone của bàn
- Tổng tiền theo bàn
- Filter theo zone
- Real-time updates khi có đơn mới

#### B. Chi tiết đơn theo bàn
```
/admin/orders/table/{table_id}
```
**Features:**
- Danh sách tất cả món của bàn
- Trạng thái từng món
- "Hoàn thành tất cả" (chỉ khi chưa giao hết)
- "Thanh toán" (chỉ khi đã giao hết)

---

### 3. **Hệ thống thanh toán** ⭐⭐⭐

#### A. Màn hình thanh toán
```
/staff/payment/table/{table_id}
```
**Features:**
- Hiển thị tổng tiền
- Chọn phương thức:
  - Sepay QR Code
  - VNPay QR Code
  - Chuyển khoản
- Hiển thị QR Code (tạo từ payment gateway)
- Countdown timer (5 phút)
- "Xác nhận thanh toán" (manual confirm)
- "Hủy"

#### B. Tích hợp Payment Gateway
- **Sepay**: API tạo QR Code
- **VNPay**: API tạo QR Code
- **Webhook**: Nhận callback khi thanh toán thành công
- **Real-time notification**: Bắn noti về admin khi thanh toán thành công

---

### 4. **Real-time Notifications** ⭐⭐⭐

#### A. Notification Types
1. **Đơn mới**: "Bàn {table_number} - {zone} có đơn mới"
2. **Món đã giao**: "Bàn {table_number} - {zone} đã giao món {menu_name}"
3. **Thanh toán thành công**: "Bàn {table_number} - {zone} đã thanh toán {amount} VNĐ"

#### B. Implementation
- **Option 1**: Laravel Echo + Pusher (recommended)
- **Option 2**: Laravel Broadcasting + Redis
- **Option 3**: Polling (fallback, không real-time thật)

#### C. Notification Center
- Badge số lượng noti chưa đọc
- Dropdown danh sách noti
- Click noti → Navigate đến đơn tương ứng
- Mark as read

---

### 5. **Cải tiến Database** ⭐

#### A. Thêm columns
```sql
-- transactions table
ALTER TABLE transactions ADD COLUMN staff_id INT NULL; -- Nhân viên đặt món
ALTER TABLE transactions ADD COLUMN order_group_id INT NULL; -- Group orders cùng bàn, cùng thời gian

-- tables table (đã có zone)
-- OK

-- payments table (nếu chưa có)
CREATE TABLE payments (
    id INT PRIMARY KEY,
    transaction_id INT,
    payment_method VARCHAR(50), -- 'sepay_qr', 'vnpay_qr', 'bank_transfer'
    qr_code_url TEXT,
    amount DECIMAL(10,2),
    status VARCHAR(20), -- 'pending', 'success', 'failed'
    payment_gateway_response TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### B. Tạo model mới
- `OrderGroup`: Group các orders cùng bàn, cùng thời gian
- `Notification`: Lưu notifications

---

## 📐 THIẾT KẾ GIAO DIỆN

### 1. **Màn hình chọn bàn (Staff)**
```
┌─────────────────────────────────────┐
│  [←] Chọn bàn                        │
├─────────────────────────────────────┤
│  [Search bàn...]  [Filter: Zone ▼]  │
├─────────────────────────────────────┤
│  Khu vực: Ban công                   │
│  ┌───┐ ┌───┐ ┌───┐ ┌───┐           │
│  │T01│ │T02│ │T03│ │T04│           │
│  │🟢 │ │🟡 │ │🔴 │ │🟢 │           │
│  └───┘ └───┘ └───┘ └───┘           │
│                                      │
│  Khu vực: Trong nhà                  │
│  ┌───┐ ┌───┐ ┌───┐ ┌───┐           │
│  │T05│ │T06│ │T07│ │T08│           │
│  │🟡 │ │🔴 │ │🟢 │ │🟡 │           │
│  └───┘ └───┘ └───┘ └───┘           │
└─────────────────────────────────────┘
```

### 2. **Màn hình đặt món (Staff)**
```
┌─────────────────────────────────────┐
│  [←] Ban công - Bàn T01             │
├─────────────────────────────────────┤
│  [Món ăn] [Đồ uống] [Lẩu]          │
├─────────────────────────────────────┤
│  ┌─────────────────────────────┐  │
│  │ Bia hơi Hà Nội (Cốc)         │  │
│  │ 15.000đ                      │  │
│  │ [+ Thêm]                     │  │
│  └─────────────────────────────┘  │
│  ┌─────────────────────────────┐  │
│  │ Bia Hà Nội chai             │  │
│  │ 26.000đ                      │  │
│  │ [+ Thêm]                     │  │
│  └─────────────────────────────┘  │
├─────────────────────────────────────┤
│  Đơn hiện tại: 2 món - 41.000đ    │
│  [Xem đơn] [Xác nhận đặt món]      │
└─────────────────────────────────────┘
```

### 3. **Màn hình quản lý đơn theo bàn (Staff)**
```
┌─────────────────────────────────────┐
│  [←] Ban công - Bàn T01             │
├─────────────────────────────────────┤
│  Đơn #1 - 14:30                     │
│  ✓ Bia hơi Hà Nội (Cốc) - 15.000đ  │
│  ⏳ Bia Hà Nội chai - 26.000đ       │
│  ────────────────────────────────  │
│  Tổng: 41.000đ                      │
│  [Thanh toán] (chỉ khi tất cả ✓)   │
├─────────────────────────────────────┤
│  Đơn #2 - 15:00                     │
│  ⏳ Lạc rang - 15.000đ              │
│  ────────────────────────────────  │
│  Tổng: 15.000đ                      │
│  [Thanh toán]                       │
└─────────────────────────────────────┘
```

### 4. **Màn hình thanh toán (Staff)**
```
┌─────────────────────────────────────┐
│  [←] Thanh toán - Ban công - Bàn T01│
├─────────────────────────────────────┤
│  Tổng tiền: 41.000đ                 │
│                                      │
│  Chọn phương thức:                  │
│  ○ Sepay QR Code                    │
│  ○ VNPay QR Code                    │
│  ○ Chuyển khoản                     │
│                                      │
│  ┌─────────────────────────────┐  │
│  │      [QR CODE IMAGE]         │  │
│  │                              │  │
│  │   Quét mã để thanh toán      │  │
│  │                              │  │
│  │   ⏱️ 4:32                    │  │
│  └─────────────────────────────┘  │
│                                      │
│  [Xác nhận thanh toán] [Hủy]        │
└─────────────────────────────────────┘
```

---

## 🎨 CẢI TIẾN GIAO DIỆN

### 1. **Color Scheme**
- Primary: Cam (#ec7f13) - Giữ nguyên
- Success: Xanh lá - Đã giao
- Warning: Vàng - Đang xử lý
- Danger: Đỏ - Chưa thanh toán
- Info: Xanh dương - Thông tin

### 2. **Icons**
- Material Symbols (đã có)
- Thêm icons cho:
  - 🍽️ Bàn (table_restaurant)
  - 📍 Khu vực (location_on)
  - 💳 Thanh toán (payments)
  - 🔔 Thông báo (notifications)

### 3. **Responsive**
- Mobile-first design
- Touch-friendly buttons (min 44x44px)
- Swipe gestures cho mobile

---

## 📝 TASK BREAKDOWN

### Phase 1: Core Features (Ưu tiên cao)
1. ✅ Tạo màn hình chọn bàn (Staff)
2. ✅ Tạo màn hình đặt món nhanh (Staff)
3. ✅ Cải tiến quản lý đơn theo bàn (Admin/Staff)
4. ✅ Tạo màn hình thanh toán (Staff)

### Phase 2: Payment Integration (Ưu tiên trung bình)
5. ⏳ Tích hợp Sepay QR Code API
6. ⏳ Tích hợp VNPay QR Code API
7. ⏳ Webhook callback handling
8. ⏳ Payment status tracking

### Phase 3: Real-time (Ưu tiên trung bình)
9. ⏳ Setup Laravel Echo + Pusher
10. ⏳ Real-time notifications
11. ⏳ Notification center UI

### Phase 4: Polish (Ưu tiên thấp)
12. ⏳ Animation & transitions
13. ⏳ Loading states
14. ⏳ Error handling
15. ⏳ Testing

---

## 🔧 TECHNICAL STACK

### Backend
- Laravel 10+
- Laravel Echo (real-time)
- Pusher / Redis (broadcasting)

### Frontend
- Blade Templates
- Bootstrap 5
- Tailwind CSS
- Material Symbols Icons
- JavaScript (Vanilla hoặc Alpine.js)

### Payment
- Sepay API
- VNPay API
- QR Code generation library

---

## 📊 METRICS & KPIs

### Cần theo dõi
1. Số đơn đặt trong ngày
2. Thời gian trung bình từ đặt → giao
3. Thời gian trung bình từ giao → thanh toán
4. Tỷ lệ thanh toán thành công
5. Doanh thu theo khu vực

---

## ✅ NEXT STEPS

1. **Review document này** với team
2. **Xác nhận quy trình** với business
3. **Bắt đầu Phase 1**: Core Features
4. **Test với dữ liệu thật**
5. **Iterate & improve**

---

**Tạo bởi**: AI Assistant  
**Ngày**: 2025-12-21  
**Version**: 1.0

