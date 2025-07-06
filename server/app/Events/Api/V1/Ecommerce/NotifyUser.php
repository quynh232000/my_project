<?php

namespace App\Events\Api\V1\Ecommerce;


use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user_id;
    public $notifyHistory;
    public function __construct($notifyHistory)
    {
        $this->notifyHistory = $notifyHistory;
    }
    public function broadcastOn(): array
    {
        return [
            'notify_shop.' . $this->notifyHistory->user_id,
        ];
    }
    public function broadcastAs()
    {
        return 'notify_shop';
    }
}
