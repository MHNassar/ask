<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ConversationUser;
use Illuminate\Http\Request;

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
        $userId = $user->id;
        if ($user->type == 0) {
            $convs = ConversationUser::where('user_id', $userId)->with('conversation')->get();
            return $convs;

        } else {
            $convs = ConversationUser::where('user_id', $userId)
                ->with('conversationAccepted')
                ->with('conversationNotAccepted')->get();
            return $convs;
        }

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

    public function sendMessage()
    {

    }

    public function getConvDetails()
    {

    }

}
