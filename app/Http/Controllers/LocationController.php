<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getCountries()
    {
        $countries = Country::all();

        $result = [
            'countries' => $countries,
            'status' => 'success',
        ];

        return response( $result, 200 );
    }

    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->get();

        $result = [
          'states' => $states,
          'status' =>'success',
        ];

        return response( $result, 200 );
    }

    public function getCities($country_id, $state_id)
    {
        $cities = City::where('country_id', $country_id)->where('state_id', $state_id)->get();

        $result = [
            'cities' => $cities,
          'status' =>'success',
        ];

        return response( $result, 200 );
    }

    public function getCurrencies()
    {
        $currencies = Country::select('currency', 'currency_name')->get();

        return response([
            'status' => 'success',
            'currencies' => $currencies
        ], 200);
    }
}
