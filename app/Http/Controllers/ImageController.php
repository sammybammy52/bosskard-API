<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function getImages($filename)
    {
        $path = 'public/images/' . $filename;

        if (Storage::exists($path)) {
            $file = Storage::get($path);
            $type = Storage::mimeType($path);

            return Response::make($file, 200, ['Content-Type' => $type]);
        }

        abort(404); // Image not found
    }
}
