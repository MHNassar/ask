<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDevices extends Model
{
    public $timestamps = false;
    public $table = 'user_devices';

    public function device_type ($var = 0){
       $arr = [
            1=>'IOS',
            2=>'ANDROID',
        ];
       return ($var>0) ? $arr[$var] : $arr;
    }
}
