<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;

class StatesController extends Controller
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
}
