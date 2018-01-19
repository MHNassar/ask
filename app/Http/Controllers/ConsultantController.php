<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Models\User;
use App\Question;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    public function getConsultants()
    {
        $users = User::where('type', '1')->get();
        return $users;
    }

    public function getConsultantQuestions()
    {
        $user = UserLoginController::getUserDataByToken();
        $questionsNotAnswer = Question::where('category_id', $user->category_id)
            ->whereDoesntHave("answer")
            ->with(['user', 'category', 'answer'])->get();

        $myAnswers = Question::where('category_id', $user->category_id)->whereHas('answer', function ($query) use ($user) {
            $query->where('user_id', '=', $user->id);
        })->with(['user', 'category', 'answer'])->get();


        return response()->json(['all_category_questions' => $questionsNotAnswer, 'my_answered_questions' => $myAnswers], 200);

    }
}
