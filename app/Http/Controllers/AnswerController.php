<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AnswerController extends Controller
{
    public function createAnswer(Request $request)
    {
        $user = UserLoginController::getUserDataByToken();
        $questionId = Route::input('question_id');
        if (isset($user)) {
            if (!isset(Question::where('id', $questionId)->first()->id)) {
                return response()->json(['message' => 'Question not found'], 404);
            }
            $answer = new Answer();
            $answer->question_id = $questionId;
            $answer->user_id = $user->id;
            $answer->body = $request->body;
            $answer->save();
            if (count($user->device) > 0) {
                app(NotificationsController::class)->sendNotification($user->device->device_token, "One Answer Found");
            }
            return response()->json(['message' => 'Answer Created '], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function updateAnswer(Request $request)
    {
        $user = UserLoginController::getUserDataByToken();
        $answerId = Route::input('answer_id');
        if (isset($user)) {
            if (!isset(Answer::where('id', $answerId)->first()->id)) {
                return response()->json(['message' => 'Answer not found'], 404);
            } else if ($user->id == Answer::where('id', $answerId)->first()->user_id) {
                $answer = Answer::where('id', $answerId)->first();
                $answer->body = $request->body;
                $answer->save();
                return response()->json(['message' => 'Answer Updated '], 200);
            } else {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }


}
