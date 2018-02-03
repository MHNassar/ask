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
        $category_ids = $user->categories()->pluck('category_id');
        $myAnswers = Question::whereIn('category_id', $category_ids)->with(['user', 'category', 'answer'])->get();
        return response()->json(['question' => $myAnswers], 200);
    }
}
