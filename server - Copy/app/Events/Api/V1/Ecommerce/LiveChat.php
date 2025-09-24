<?php

namespace App\Events\Api\V1\Ecommerce;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LiveChat implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    public $livestream_id;
    public $view;
    public $status;
    public $data;
    // public $user;
    public function __construct($livestream_id, $message = null,$view =null,$status = null,$data=null)
    {
        $this->livestream_id    = $livestream_id;
        $this->message          = $message;
        $this->view             = $view;
        if($status){
            $this->status           = $status;
        }
        $this->data = $data;
    }
    public function broadcastOn(): array
    {
        return [
            'livechat.' . $this->livestream_id
        ];
    }
    public function broadcastAs()
    {
        return 'livechat';
    }
}
