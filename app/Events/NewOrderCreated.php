<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;
    public $table;

    /**
     * Create a new event instance.
     */
    public function __construct(Transaction $order)
    {
        $this->order = $order;
        $this->table = $order->table;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('orders'),
            new PrivateChannel('admin'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'order.created';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->order->id,
            'table_id' => $this->order->table_id,
            'table_number' => $this->table->table_number ?? 'N/A',
            'zone' => $this->table->zone ?? 'N/A',
            'menu_name' => $this->order->menu->name ?? 'N/A',
            'quantity' => $this->order->quantity,
            'created_at' => $this->order->created_at->toDateTimeString(),
        ];
    }
}

