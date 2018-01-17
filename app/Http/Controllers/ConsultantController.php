<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ConsultantController extends Controller
{
    public function getConsultants()
    {
        $users = User::where('type', '1')->get();
        return $users;
    }
}
