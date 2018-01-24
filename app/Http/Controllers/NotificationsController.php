<?php

namespace App\Http\Controllers;

use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function sendNotification($token, $text)
    {
        $androidApp = PushNotification::app('askAndroid');
        try {
            $androidApp->adapter->setAdapterParameters(['sslverifypeer' => false]);
            $message = PushNotification::Message($text, array());
            $androidApp->to($token)->send($message);
        } catch (\Exception $exception) {

        }


    }
}
