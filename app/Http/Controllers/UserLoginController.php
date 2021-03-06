<?php

namespace App\Http\Controllers;

use App\Mail\forgetPass;
use App\Models\User;
use App\UserDevices;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Intervention\Image\ImageManagerStatic as Image;

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
            $device_token = $request->get('device_token');
            $device_type = (int)$request->get('device_type');
            $this->insertLoggedUserDeviceData($device_type, $user->id, $device_token);

            return response()->json(['token' => $api_token, 'type' => $user->type], 200);
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

    public function editUser(Request $request)
    {
        $user = $this->getUserDataByToken();
        $input = $request->all();
        $image = Image::make($input['image']);
        $temp_name = str_random(10) . '.png';
        $image->save("public/" . $temp_name, 30);
        $input['photo'] = url("public/" . $temp_name);
        $user->update($input);
        return response()->json(['errors' => ''], 200);
    }

    public function forgetPass(Request $request)
    {
        $email = $request->email;
        $user = User::where('email', $email)->first();
        if ($user) {
            $newPass = str_random('8');
            $user->password = bcrypt($newPass);
            $user->save();
            // Send Email
//            Mail::to($user->email)->send(new forgetPass($newPass));
            return response()->json(['errors' => ''], 200);

        } else {
            return response()->json(['errors' => 'User Not Found'], 404);

        }
    }

    public function sendSug(Request $request)
    {
        return response()->json(['errors' => ''], 200);

    }

    public function insertLoggedUserDeviceData($device_type, $user_id, $device_token = null)
    {

//        $user_device = UserDevices::where('mac_address', $mac_address)->first();
//        if (!$user_device) {
        $user_device = new UserDevices();
//        }
        if ($device_token != null) {
            $user_device->device_type = $device_type;
            $user_device->device_token = $device_token;
            $user_device->user_id = $user_id;
            $user_device->save();
        }

        return "true";
    }

}