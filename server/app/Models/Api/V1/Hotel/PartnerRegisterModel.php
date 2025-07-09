<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class PartnerRegisterModel extends ApiModel
{
    public function __construct()
    {
        $this->table         = TABLE_HOTEL_PARTNER_REGISTER;
        parent::__construct();
    }
    protected $guarded = [];
    public function saveItem($params = null, $options = null) {
        if ($options['task'] == 'add-item') {
            $params['status']       = 'pending';
            $params['code']         = date('YmdHis');
            $params['type']         = $params['type'] ?? 'hotel';
            $params['created_at']   = date('Y-m-d H:i:s');
           
            try {
                $item = self::create($this->prepareParams($params));
                // $mail = new ChangeTicketMail($item);
                // Mail::to($item['email'])->send($mail);

                return [
                    'status'        => true,
                    'status_code'   => 200,
                    'message'       => 'Tạo yêu cầu thành công!'
                ];

            } catch (\Throwable $th) {
                return [
                    'status'        => false,
                    'status_code'   => 400,
                    'error'         => $th->getMessage()
                ];
            }
        }
    }
}
