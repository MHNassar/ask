<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function createQuestion(Request $request){
        $user = UserController::getUserDataByToken();
        if (!isset(Category::where('name', 'like', $request->category)->first()->id)){
            $category = new Category();
            $category->name = $request->category;
            $category->save();
            $category_id = $category->id;
        }else{
            $category_id = Category::where('name', 'like', $request->category)->first()->id;
        }
        $question = new Question();
        $question->question = $request->question;
        $question->user_id = $user->id;
        $question->category_id = $category_id;
        $question->save();
        return response()->json(['message' => 'Question Created '], 200);
    }
}
