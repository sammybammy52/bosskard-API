<?php

namespace App\Http\Controllers;

use App\Models\BusinessCategory;
use App\Models\BusinessData;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
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
            'status' => 'success',
            'businesses' => $businesses
        ], 200);
    }

    public function getBusinessesByState($state_id)
    {
        $businesses = BusinessData::with(['user', 'businessCategoryInformation'])
            ->where('state', $state_id)
            ->get();

        return response([
            'status' => 'success',
            'businesses' => $businesses
        ], 200);
    }

    public function filterSearch(Request $request)
    {
        $businesses = BusinessData::query();

        if ($request->filled('search')) {
            $businesses->where('businessName', 'LIKE', '%' . $request->input('search') . '%');
        }

        if ($request->filled('category')) {
            $businesses->where('businessCategory', $request->input('category'));
        }

        if ($request->filled('country')) {
            $businesses->where('country', $request->input('country'));
        }

        if ($request->filled('state')) {
            $businesses->where('state', $request->input('state'));
        }

        if ($request->filled('city')) {
            $businesses->where('city', $request->input('city'));
        }

        $businesses = $businesses->with(['user', 'businessCategoryInformation'])->get();

        $allCategories = BusinessCategory::all();

        $countries = Country::all();


        return response([
            'businesses' => $businesses,
            'allCategories' => $allCategories,
            'countries' => $countries,
            'status' => 'success',
        ], 200);
    }

    public function publicBusinessPage($id)
    {
        $userData = User::with(['businessData', 'socials', 'openHours'])
            ->where('id', $id)
            ->first();

        return $userData;
    }
}
