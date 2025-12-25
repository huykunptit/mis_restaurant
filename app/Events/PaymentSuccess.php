<?php

namespace App\Events;

use App\Models\Payment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccess implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $payment;
    public $table;

    /**
     * Create a new event instance.
     */
    public function __construct(Payment $payment)
    {
        $this->payment = $payment;
        $this->table = $payment->table;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('payments'),
            new PrivateChannel('admin'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'payment.success';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'payment_id' => $this->payment->id,
            'table_id' => $this->payment->table_id,
            'table_number' => $this->table->table_number ?? 'N/A',
            'zone' => $this->table->zone ?? 'N/A',
            'amount' => $this->payment->amount,
            'payment_method' => $this->payment->payment_method,
            'paid_at' => $this->payment->paid_at->toDateTimeString(),
        ];
    }
}

