<?php

namespace App\Http\Controllers;

use App\Category;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class QuestionController extends Controller
{
    public function createQuestion(Request $request)
    {
        $user = UserController::getUserDataByToken();
        if (isset($user)) {
            if (!isset(Category::where('name', 'like', $request->category)->first()->id)) {
                $category = new Category();
                $category->name = $request->category;
                $category->save();
                $category_id = $category->id;
            } else {
                $category_id = Category::where('name', 'like', $request->category)->first()->id;
            }
            $question = new Question();
            $question->question = $request->question;
            $question->user_id = $user->id;
            $question->category_id = $category_id;
            $question->save();
            return response()->json(['message' => 'Question Created '], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function updateQuestion(Request $request)
    {
        $user = UserController::getUserDataByToken();
        $questionId = Route::input('question_id');
        $question = Question::where('id', $questionId)->first();
        if (isset($user)) {
            if (isset($question)) {
                if (!isset(Category::where('name', 'like', $request->category)->first()->id)) {
                    $category = new Category();
                    $category->name = $request->category;
                    $category->save();
                    $category_id = $category->id;
                } else {
                    $category_id = Category::where('name', 'like', $request->category)->first()->id;
                }

                $question->question = $request->question;
                $question->user_id = $user->id;
                $question->category_id = $category_id;
                $question->save();

                return response()->json(['message' => 'Question Updated'], 200);
            } else {
                return response()->json(['message' => 'Question Not Found'], 404);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function deleteQuestion()
    {
        $user = UserController::getUserDataByToken();
        if (isset($user)) {
            $questionId = Route::input('question_id');
            $question = Question::where('id', $questionId)->first();
            if (isset($question)) {
                $question->delete();
                return response()->json(['message' => 'Question Deleted'], 200);
            } else {
                return response()->json(['message' => 'Question Not Found'], 404);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function listCategory()
    {
        $user = UserController::getUserDataByToken();
        if (isset($user)) {
            $categoryId = Route::input('category_id');
            $questions = Question::where('category_id', $categoryId)->get();
            return response()->json(['data' => $questions], 200);
        }else{
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
