<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function updateWebsite(Request $request)
    {
        $user_id = $request->user()->id;
        $data = $request->all();

        $website = Website::updateOrCreate([
            'user_id' => $user_id,
        ], $data);

        return [
            'status' => 'success',
        ];
    }
}
