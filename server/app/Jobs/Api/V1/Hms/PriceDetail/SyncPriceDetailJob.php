<?php

namespace App\Jobs\Api\V1\Hms\PriceDetail;

use App\Models\Api\V1\Hms\PriceDetailModel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncPriceDetailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $dataInsert;
    public bool $isOverwrite;
    public   $user_id;

    public function __construct(array $dataInsert, bool $isOverwrite = false,$user_id)
    {
        $this->dataInsert   = $dataInsert;
        $this->isOverwrite  = $isOverwrite;
        $this->user_id      = $user_id;
    }

    public function handle(): void
    {
        PriceDetailModel::syncPriceDetail($this->dataInsert, $this->isOverwrite,$this->user_id);
    }
}