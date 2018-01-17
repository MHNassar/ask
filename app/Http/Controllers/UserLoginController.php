<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{


    public function register(Request $request)
    {
        $input = $request->all();
        $input['name'] = $input['f_name'] . ' ' . $input['l_name'];
        $input['password'] = bcrypt($input['password']);
        try {
            User::create($input);

            return response()->json(['message' => 'User Created '], 200);
        } catch (QueryException $ex) {
            return response()->json(['message' => 'SomeThing Error'], 400);
        }

    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
            $user = Auth::user();
            if ($user->token == null) {
                $api_token = str_random(100);
                $user->token = $api_token;
                $user->save();
            } else {
                $api_token = $user->token;
            }
            return response()->json(['token' => $api_token], 200);
        }
        return response()->json(['token' => ''], 401);

    }

    public static function getUserDataByToken($token = null)
    {
        $token = $token ?: \Illuminate\Support\Facades\Request::header('token');
        $user = User::where('token', $token)->first();
        return $user;
    }

    public function getUser()
    {
        return $this->getUserDataByToken();
    }
}