<?php

namespace App\Events\Api\V1\Ecommerce;


use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Notify implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user_id;
    public $notify;
    public function __construct($notify)
    {
        $this->notify = $notify;
    }
    public function broadcastOn(): array
    {
        $data = ['notify_shop.' . $this->notify->user_id];

        if($this->notify->notification->to =='WEB'){
            $data = ['notify_web.' . $this->notify->user_id];
        }

        return $data;

    }
    public function broadcastAs()
    {
        $data = 'notify_shop' ;
        if($this->notify->notification->to =='WEB'){
            $data = 'notify_web';
        }
        return $data;
    }
}
