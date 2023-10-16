<?php

namespace App\Http\Controllers;

use App\Models\BusinessData;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function setProfileInfo(Request $request)
    {
        
    }

    public function getProfileInfo(Request $request)
    {
        $user_id = $request->user()->id;

        $userData = User::with(['businessData', 'socials'])
            ->where('id', $user_id)
            ->first();

        // $userData = BusinessData::where('user_id', $user_id)->first();


        return $userData;
    }
}
