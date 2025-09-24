<?php

namespace App\Jobs\Api\V1\Ecommerce;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendOrderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $view;
    public $data;
    public function __construct($view, $data)
    {
        $this->view = $view;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mailData = $this->data;
        Mail::send($this->view, ['data' => $this->data], function ($message) use ($mailData) {
            $message->to($mailData['email'])->subject($mailData['title']);
        });
    }
}
