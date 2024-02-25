<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicUploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/images', $imageName);

        return response([
            'status' => 'success',
            'imageName' => $imageName,
        ]);
    }
}
