<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialsController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'user_id' => $request->user()->id,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'whatsapp' => $request->whatsapp,
            'website' => $request->website,
        ];




    }
}
