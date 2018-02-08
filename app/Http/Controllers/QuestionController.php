<?php

namespace App\Http\Controllers;

use App\BuildingKind;
use App\Category;
use App\ConstructionsKind;
use App\Like;
use App\Models\User;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as Image;


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
        $user = UserLoginController::getUserDataByToken();

        $questions = User::where('id', $user->id)->with('likes.question')->get();
        return $questions;

    }

    public function getUserQuestions()
    {
        $user = UserLoginController::getUserDataByToken();
        $questions = User::where('id', $user->id)
            ->with('questionsWithAnswer')
            ->with('questionsWithOutAnswer')
            ->get();
        return $questions;
    }


    public function createQuestion(Request $request)
    {
        $user = UserLoginController::getUserDataByToken();
        if (isset($user)) {
            if (!isset(Category::where('name', 'like', $request->category)->first()->id)) {
                $category = new Category();
                $category->name = $request->category;
                $category->save();
                $category_id = $category->id;
            } else {
                $category_id = Category::where('name', 'like', $request->category)->first()->id;
            }

            if (!isset(BuildingKind::where('name', 'like', $request->building)->first()->id)) {
                $building = new BuildingKind();
                $building->name = $request->building;
                $building->save();
                $building_id = $building->id;
            } else {
                $building_id = BuildingKind::where('name', 'like', $request->building)->first()->id;
            }

            if (!isset(ConstructionsKind::where('name', 'like', $request->construction)->first()->id)) {
                $construction = new ConstructionsKind();
                $construction->name = $request->construction;
                $construction->save();
                $construction_id = $construction->id;
            } else {
                $construction_id = ConstructionsKind::where('name', 'like', $request->construction)->first()->id;
            }

            // uploade image if found

            $imagePath = "";
            if ($request->image != "") {
                $image = Image::make($request->image);
                $temp_name = str_random(10) . '.png';
                $image->save("public/" . $temp_name, 30);
                $imagePath = url("public/" . $temp_name);
            }


            $question = new Question();
            $question->question = $request->question;
            $question->user_id = $user->id;
            $question->category_id = $category_id;
            $question->building_id = $building_id;
            $question->construction_id = $construction_id;
            $question->image = $imagePath;
            $question->save();

            $categoryUsers = \App\Category::find($category_id)->users()->pluck('user_id');
            $consultants = User::whereIn('id', $categoryUsers);

            foreach ($consultants as $item) {
                if ($item->device->device_type == 1) {
                    app(NotificationsController::class)->sendNotification($item->device->device_token, "Some Question Found");
                }

            }

            return response()->json(['message' => 'Question Created '], 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function updateQuestion(Request $request)
    {
        $user = UserLoginController::getUserDataByToken();
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

                if (!isset(BuildingKind::where('name', 'like', $request->building)->first()->id)) {
                    $building = new BuildingKind();
                    $building->name = $request->building;
                    $building->save();
                    $building_id = $building->id;
                } else {
                    $building_id = BuildingKind::where('name', 'like', $request->building)->first()->id;
                }

                if (!isset(ConstructionsKind::where('name', 'like', $request->construction)->first()->id)) {
                    $construction = new ConstructionsKind();
                    $construction->name = $request->building;
                    $construction->save();
                    $construction_id = $construction->id;
                } else {
                    $construction_id = ConstructionsKind::where('name', 'like', $request->construction)->first()->id;
                }

                $question->question = $request->question;
                $question->user_id = $user->id;
                $question->category_id = $category_id;
                $question->building_id = $building_id;
                $question->construction_id = $construction_id;
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
        $user = UserLoginController::getUserDataByToken();
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
        $user = UserLoginController::getUserDataByToken();
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
        $user = UserLoginController::getUserDataByToken();
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
        $user = UserLoginController::getUserDataByToken();
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

    public function filter(Request $request)
    {
        $user = UserLoginController::getUserDataByToken();
        $common = $request->common;
        $construction = $request->construction;
        $building = $request->building;
        $category = $request->category;
        if (isset($user)) {
            if ($common == 1) {
                $questions = Question::orderBy('likes_count', 'DESC')->with(['user', 'category', 'answer']);
            } else {
                $questions = Question::orderBy('created_at', 'DESC');
            }

            if (isset($construction) and $construction != "") {
                $construction_id = ConstructionsKind::where('name', 'like', '%' . $construction . '%')->first();
                if (!$construction_id) {
                    return response()->json(['message' => 'Construction Not Found'], 400);
                }
                $questions = $questions->where('construction_id', $construction_id->id);
            }
            if (isset($building) and $building != "") {
                $building_id = BuildingKind::where('name', 'like', '%' . $building . '%')->first();
                if (!$building_id) {
                    return response()->json(['message' => 'Building Not Found'], 400);
                }
                $questions = $questions->where('building_id', $building_id->id);
            }

            if (isset($category) and $category != "") {
                $category_id = Category::where('name', 'like', '%' . $category . '%')->first();
                if (!$category_id) {
                    return response()->json(['message' => 'Category Not Found'], 400);
                }
                $questions = $questions->where('category_id', $category_id->id);
            }

            return $questions->get();
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
