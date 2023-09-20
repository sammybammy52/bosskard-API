<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{

    public function setVerifyPhone($id)
    {
        $user = User::find($id);

        $user->phone_verification = 1;

        $user->save();

        return response([
            'status' => 'success',
        ], 200);
    }

    // public function initializePhoneVerification(Request $request)
    // {
    //     $client = new TextFlowClient("UB9hG67cJmwcgeBLZ9g344Q6bgxsMcnGyJnRqKse9aALZQLT4eB96w10lpvoVglp");

    //     $client->send_sms($request->phone, "sf");

    //     return ['success' => true];

    // }

    // public function verifyPhone()
    // {
    //     //collect the code and check if the code is valid with the phone number
    // }
}
