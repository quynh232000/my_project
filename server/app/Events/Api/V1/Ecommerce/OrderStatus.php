<?php

namespace App\Events\Api\V1\Ecommerce;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $order_id;
    public $status;
    // public $user;
    public function __construct($order_id, $status)
    {
        $this->order_id = $order_id;
        $this->status   = $status;
    }
    public function broadcastOn(): array
    {
        return [
            'order_status.' . $this->order_id
        ];
    }
    public function broadcastAs()
    {
        return 'order_status';
    }
}
