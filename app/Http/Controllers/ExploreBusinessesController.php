<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\BusinessData;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;

class ExploreBusinessesController extends Controller
{
    public function exploreFeaturedData()
    {
        $categories = BusinessCategory::all();

        $states = State::where('country_id', 161)->get();

        return response([
            'status' => 'success',
            'categories' => $categories,
            'states' => $states
        ], 200);
    }

    public function getBusinessesByCategory($category_id)
    {
        $businesses = BusinessData::with(['user', 'businessCategoryInformation'])
            ->where('businessCategory', $category_id)
            ->get();

            return response([
              'status' =>'success',
                'businesses' => $businesses
            ], 200);
    }
}
