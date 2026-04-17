<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderPlaced implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $order;

    public function __construct(Order $order, int $notificationId, int $unreadCount)
    {
        $this->order = [
            'id' => (int) $order->id,
            'email' => (string) $order->email,
            'status' => (string) $order->status,
            'payment_method' => (string) $order->payment_method,
            'total' => (float) $order->total,
            'created_at' => (string) $order->created_at,
            'notification_id' => $notificationId,
            'unread_count' => $unreadCount,
        ];
    }

    public function broadcastOn()
    {
        return new Channel('admin-orders');
    }

    public function broadcastAs()
    {
        return 'new-order';
    }
}
