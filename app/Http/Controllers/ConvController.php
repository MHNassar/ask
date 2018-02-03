<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\Message;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ConvController extends Controller
{
    //


    public function requestConv(Request $request)
    {
        $receiver_id = $request->receiver_id;
        $sender_id = UserLoginController::getUserDataByToken()->id;

        $conv = new Conversation();
        $conv->approved = false;
        $conv->save();

        $convUsers = new ConversationUser();
        $convUsers->conversation_id = $conv->id;
        $convUsers->user_id = $sender_id;
        $convUsers->save();

        $convUsers = new ConversationUser();
        $convUsers->conversation_id = $conv->id;
        $convUsers->user_id = $receiver_id;
        $convUsers->save();

        // send notification ..... to consultant

        return response()->json(['message' => 'Request Sent '], 200);

    }

    public function getConvList()
    {
        $user = UserLoginController::getUserDataByToken();

        $approved = $user->conversationsApproved()->with(['usersFilter' => function ($query) use ($user) {
            $query->where('user_id', '!=', $user->id);
            $query->select('id', 'name', 'photo');
        }])->get();

        $notApproved = $user->conversationsNotApproved()->with(['usersFilter' => function ($query) use ($user) {
            $query->where('user_id', '!=', $user->id);
            $query->select('id', 'name', 'photo');
        }])->get();

        return response()->json(['convs_approved' => $approved, 'convs_not_approved' => $notApproved], 200);

    }

    public function acceptConv(Request $request)
    {
        $convId = $request->conv_id;
        $conv = Conversation::find($convId);
        $conv->approved = true;
        $conv->save();
        // send notification to user

        return response()->json(['message' => 'Request Sent '], 200);

    }

    public function sendMessage(Request $request)
    {
        $user = UserLoginController::getUserDataByToken();
        $type = $request->type;
        if ($type == 'text') {
            $body = $request->message;
        } elseif ($type == 'image') {
            $image = Image::make($request->messag);
            $temp_name = str_random(10) . '.png';
            $image->save("public/" . $temp_name, 30);
            $body = url("public/" . $temp_name);
        } elseif ($type == 'voice') {
            $voice = base64_decode($request->message);
            $name = date("YmdHis") . "_" . mt_rand(100000000, 999999999) . '.mp3';
            $path = 'public/' . $name;
            file_put_contents($path, $voice);
            $body = $path;
        }

        $newMsg = new Message();
        $newMsg->body = $body;
        $newMsg->conversation_id = $request->conversationId;
        $newMsg->user_id = $user->id;
        $newMsg->type = $request->type;
        $newMsg->save();

        return response()->json(['message' => 'Message Sent', 'data' => $newMsg], 200);

    }

    public function getConvDetails($conversationId)
    {
        $messages = Message::where('conversation_id', $conversationId)->with(['users' =>
            function ($query) {
                $query->select('id', 'name', 'photo');
            }])->orderBy('created_at', 'DESC')->get();
        return response()->json($messages);
    }

}
