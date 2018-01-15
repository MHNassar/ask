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
        $user = UserController::getUserDataByToken();
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
            return response()->json(['message' => 'Answer Created '], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
