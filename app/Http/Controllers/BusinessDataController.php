<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\BusinessData;
use App\Models\User;
use Illuminate\Http\Request;

class BusinessDataController extends Controller
{
    public function store(Request $request)
    {
        //store the logo
        $image = $request->file('businessLogo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/images', $imageName);

        $user_id = $request->user()->id;

        $data = $request->all();

        $data['user_id'] = $user_id;

        unset($data['businessLogo']);

        $businessData = BusinessData::create($data);
        //update user info
        $userData = User::find($user_id);
        $userData->businessLogo = $imageName;
        $userData->isSetupBusiness = 1;
        $userData->save();

        return response([
            'status' => 'success',
            'user' => $userData
        ], 201);

    }

    public function getBusinessCategoryList()
    {
        $categories = BusinessCategory::all();

        return response($categories, 200);
    }
}
