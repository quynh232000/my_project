<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Jobs\Api\V1\Ecommerce\SendNotificationJob;
use App\Models\ApiModel;

class NotificationModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
    public function saveItem($data, $options = [])
    {
        if ($options['task'] == 'add-item') {

            $item = self::create([
                'title'         => $data['title'],
                'message'       => $data['message'],
                'from'          => 'SYSTEM',
                'to'            => $data['to'],
                'sent_type'     => $data['sent_type'],
                'status'        => $data['sent_type'] == 'IMMEDIATE' ? 'SENT' : 'PENDING',
                'type_target'   => $data['type_target'],
                'target_ids'    => json_encode($data['target_ids'] ?? [[]]),
                'schedule_at'   => $data['schedule_at'] ?? null,
                'is_html'       => true,
                'is_send_mail'  => $data['is_send_mail'] == 'true' ? true : false,
            ])->toArray();
            if ($item['sent_type'] == 'IMMEDIATE') {
                $this->sendNotify($item);
            }
        }
    }
    public function sendNotify($notify)
    {
        switch ($notify['type_target']) {
            case 'ALL':
                // Send notification to all users
                $users = UserModel::all()->toArray();
                foreach ($users as $user) {
                    SendNotificationJob::dispatch($notify, $user);
                }
                break;
            case 'GROUP':
                // Send notification to group users
                foreach (json_decode($notify['target_ids']) as $id) {
                    $user_ids       = UserRoleModel::where(['role_id' => $id])->pluck('user_id')->toArray();
                    $users          = UserModel::whereIn('id', $user_ids)->get();
                    foreach ($users as $user) {
                        SendNotificationJob::dispatch($notify, $user);
                    }
                }
                break;
            case 'USER':
                // Send notification to specific user
                foreach (json_decode($notify['target_ids']) as $id) {
                    $user = UserModel::find($id);
                    SendNotificationJob::dispatch($notify, $user);
                }
                break;
            default:
                # code...
                break;
        }
    }
}
