<?php

namespace App\Http\Controllers;

use App\Category;
use App\Like;
use App\Models\User;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class QuestionController extends Controller
{
    public function getAllQuestions($q = null)
    {
        $questions = Question::has('answer')->with(['user', 'category', 'answer']);
        if ($q != null) {
            $questions = $questions->where('question', 'like', '%' . $q . '%');
        }
        $questions = $questions->get();
        return $questions;
    }

    public function getLikedQuestions()
    {
        $user = UserController::getUserDataByToken();

        $questions = User::where('id', $user->id)->with('likes.question')->get();
        return $questions;

    }

    public function getUserQuestions()
    {
        $user = UserController::getUserDataByToken();
        $questions = User::where('id', $user->id)
            ->with('questionsWithAnswer')
            ->with('questionsWithOutAnswer')
            ->get();
        return $questions;
    }


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
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function likeQuestion()
    {
        $user = UserController::getUserDataByToken();
        if (isset($user)) {
            $questionId = Route::input('question_id');
            $question = Question::where('id', $questionId)->first();
            if (isset($question)) {

                // if auth user like this question before, we will go to unlike action
                $existLike = Like::where('question_id', $questionId)->where('user_id', $user->id)->first();
                if (isset($existLike)) {
                    return QuestionController::unLikeQuestion();
                } else {
                    $like = new Like();
                    $like->question_id = $questionId;
                    $like->user_id = $user->id;
                    $like->save();

                    $question->likes_count += 1;
                    $question->save();
                }

                return response()->json(['message' => 'Like Question Done'], 200);
            } else {
                return response()->json(['message' => 'Question Not Found'], 404);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function unLikeQuestion()
    {
        $user = UserController::getUserDataByToken();
        if (isset($user)) {
            $questionId = Route::input('question_id');
            $question = Question::where('id', $questionId)->first();
            if (isset($question)) {

                $like = Like::where('question_id', $questionId)->where('user_id', $user->id)->first();
                if (isset($like)) {
                    $like->delete();
                    $question->likes_count -= 1;
                    $question->save();
                    return response()->json(['message' => 'Unlike Question Done'], 200);
                }

            } else {
                return response()->json(['message' => 'Question Not Found'], 404);
            }
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
