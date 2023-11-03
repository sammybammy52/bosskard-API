<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function createMyCard( Request $request )
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'phone_1' => 'required|string',
            'email' => 'required|string',
            'company_name' => 'required|string',
            'logo' => 'required|image|max:2048',
            'filler_id' => 'required'
        ]);

        //store the logo for the card
        $image = $request->file('logo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/images', $imageName);


        $data = [
            'name' => $request->name,
            'role' => $request->role,
            'phone_1' => $request->phone_1,
            'email' => $request->email,
            'website' => $request->website,
            'address' => $request->address,
            'company_name' => $request->company_name,
            'logo' => $request->logo,

        ];
    }

    public function editCard( Request $request )
    {

    }

    public function deleteCard( Request $request )
    {

    }

    public function listCards( Request $request )
    {

    }

    public function createThirdPartyCard ( Request $request )
    {

    }
}
