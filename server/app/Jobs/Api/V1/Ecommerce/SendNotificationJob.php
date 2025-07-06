<?php

namespace App\Jobs\Api\V1\Ecommerce;

use App\Events\Api\V1\Ecommerce\Notify;
use App\Models\Api\V1\Ecommerce\NotificationHistoryModel;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Mail;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $notify;
    public $user;

    public function __construct($notify, $user)
    {
        $this->notify = $notify;
        $this->user   = $user;
    }

    public function handle(): void
    {

        $notify =  NotificationHistoryModel::create([
            'notification_id' => $this->notify['id'],
            'user_id'         => $this->user['id'],
            'is_read'         => false,
            'is_count'        => false,
        ]);
        $notify->load(['user','notification']);

        event(new Notify($notify));

        if (!empty($this->notify['is_send_mail']) && $this->notify['is_send_mail'] == true) {
            $data['notify'] = $this->notify;
            $data['user']   = $this->user;

            Mailer::html($data['notify']['message'], function ($message) use ($data) {
                $message->to($data['user']['email'])
                    ->subject('[Quin Ecommerce] - Thông báo - '.$data['notify']['title']);
            });
        }
    }
}

