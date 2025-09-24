<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Events\Api\V1\Ecommerce\Message;
use App\Http\Controllers\Controller;
use App\Models\Api\V1\Ecommerce\ConversationModel;
use App\Models\Api\V1\Ecommerce\MessageModel;
use App\Models\Api\V1\Ecommerce\ShopModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Validator;

class ChatController extends Controller
{
    function message(Request $request)
    {
        // $user = User::find("14");
        // event(new Noti($user->id, "hello"));
        // event(new NewNotification($user->id, "okokok"));
        // event(new Message($user));
        // broadcast(new Message($request->username,$request->message));
        // $user = auth()
        // broadcast(new Noti(auth()->id()));

        return response()->json(['status' => 'Message broadcasted successfully'], 200);
    }
    public function getMessage(Request $request, $id)
    {

        $data['conversation'] = ConversationModel::firstOrCreate([
            'user_id' => auth('ecommerce')->id(),
            'shop_id' => $id
        ], [
            'user_id' => auth('ecommerce')->id(),
            'shop_id' => $id
        ]);
        // $data['conversation'] = $data['conversation']->load(['user','shop']);
        $data['message'] = MessageModel::where('conversation_id', $data['conversation']->id)
            ->limit(30)
            ->orderBy('created_at', 'desc')
            ->get();

        $data['message']->each(function ($message) {
            if ($message->type == 'user') {
                $message->user = $message->user;

            } else {
                $message->shop = ShopModel::find($message->sender_id);

            }
        });


        MessageModel::where(function ($query) use ($data) {
            $query->where('conversation_id', $data['conversation']->id)
                ->where(['sender_id' => auth('ecommerce')->id(), 'type' => 'user']);
        })->update(['is_read' => 1]);


        return $this->successResponse('Lấy tin nhắn thành công!', $data);
    }
    public function sendMessage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'conversation_id' => 'required',
            'type' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->errorResponse("Vui lòng nhập đầy đủ thông tin!", $validator->errors());
        }
        $conversation = ConversationModel::find($request->conversation_id);
        if ($conversation == null) {
            return $this->errorResponse('No Conversation');
        }
        $message = [
            'conversation_id' => $request->conversation_id,
            'sender_id' =>$request->type =='shop' ? auth('ecommerce')->user()->shop->id: auth('ecommerce')->id(),
            'content' => $request->input('content'),
            'type' => $request->type
        ];
        if ($request->medias) {
            $files = [];
            $FileService = new FileService();
            foreach ($request->medias as $media) {
                $files[] = $FileService->uploadFile($media)['url'];
            }
            $message['media'] = json_encode($files);

        }
        $message = MessageModel::create($message);
        if($message->type == 'user'){
            $message->user =$message->user;
        }else{
            $message->shop =$message->shop;
        }
        event(new Message($conversation, $message));
        return $this->successResponse("Gửi tin nhắn thành công!", $message);
    }
    public function deleteMessage($message_id)
    {
        MessageModel::find($message_id)->delete();

        return $this->successResponse("Xóa tin nhắn thành công!");
    }
    public function getConversations()
    {
        $user = auth()->user();

        $conversations = ConversationModel::where(function ($query) use ($user) {
            $query->where('user1_id', $user->id)
                ->orWhere('user2_id', $user->id);
        })->limit(10)->get()->map(function ($conversation) {
            $conversation->user = $conversation->user();
            $conversation->recent_message = $conversation->recent_message();
            return $conversation;
        });
        return $this->successResponse("Lấy danh sách đoạn chat thành công!", $conversations);
    }
    public function list()
    {
        $shop = auth('ecommerce')->user()->shop;
        $conversations = ConversationModel::where('shop_id', $shop->id)
            ->with([
                'user',
                'messages' => function ($query) {
                    $query->orderBy('created_at', 'desc')->limit(1)->get();
                }
            ])
            ->orderBy('created_at', 'desc')->get();

        return $this->successResponse("Lấy danh sách đoạn chat thành công!", $conversations);
    }
    public function by_id($cons_id)
    {
        $data['conversation'] = ConversationModel::with('user', 'shop')->find($cons_id);
        $data['message'] = MessageModel::where('conversation_id', $data['conversation']->id)
            ->limit(30)
            ->orderBy('created_at', 'desc')
            ->get();

        $data['message']->each(function ($message) {
            $message->is_read = true;
            $message->save();
            if ($message->type == 'user') {
                $message->user = $message->user;

            } else {
                $message->shop = $message->shop;

            }
            // Mark message as read

        });
        return $this->successResponse("Lấy tin nhắn thành công!", $data);
    }
    public function countMessageNotRead(){
        $conver_ids = ConversationModel::where('shop_id',auth('ecommerce')->user()->shop->id)->pluck('id')->all();
        // return $conver_ids;
        $count      = MessageModel::whereIn('conversation_id',$conver_ids)->where(['type'=>'user','is_read'=>0])->count() ?? 0;
        return $this->successResponse('Thông tin tin nhắn chưa đọc thành công!', $count);
    }
}
