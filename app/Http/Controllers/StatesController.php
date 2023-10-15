<?php

namespace App\Http\Controllers;

use App\Models\Lga;
use App\Models\State;
use Illuminate\Http\Request;

class StatesController extends Controller
{
    public function stateAndLga()
    {
        $states = State::all();
        $lga = Lga::all();

        $result = [
            'states' => $states,
            'lga' => $lga
        ];

        return response()->json($result);
    }
}
