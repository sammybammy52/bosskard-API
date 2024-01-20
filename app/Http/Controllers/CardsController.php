<?php

namespace App\Http\Controllers;

use App\Models\BusinessData;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CardsController extends Controller
{
    public function createCard( Request $request )
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'phone_1' => 'required|string',
            'email' => 'required|string',
            //'company_name' => 'required|string',
            'logo' => 'required|max:2048',
            'filler_id' => 'required',
            'template' => 'required'
        ]);

        //store the logo for the card
        $image = $request->file('logo');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('public/images', $imageName);


        $data = [
            'name' => $request->name,
            'role' => $request->role,
            'phone_1' => $request->phone_1,
            'phone_2' => $request->phone_2,
            'email' => $request->email,
            'website' => $request->website,
            'address' => $request->address,
            'company_name' => $request->company_name,
            'logo' => $imageName,
            'color_1' => $request->color_1,
            'color_2' => $request->color_2,
            'logoX' => $request->logoX,
            'logoY' => $request->logoY,
            'filler_id' => $request->user()->id,
            'template' => $request->template

        ];

        $isMyCard = json_decode($request->isMyCard);

        if ($isMyCard === true) {
            $businessData = BusinessData::where('user_id', $request->user()->id)->first();
            $data['claimed'] = 1;
            $data['business_id'] = $businessData->user_id;
            $data['isMyCard'] = 1;
        }

        $card = Card::create($data);

        return response([
            'status' => 'success',
            'data' => $card
        ]);
    }

    public function editCard( Request $request )
    {
        $data = $request->all();
        $card_id = $request->card_id;

        $card = Card::find($card_id);

        if ($request->hasFile('logo')) {
            //store the new image
             $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/images', $imageName);

            //Retrieve the previous logo name from the database

            $previousLogo = $card->logo;

            // Delete the previous logo file if it exists
            if ($previousLogo && Storage::exists('public/images/' . $previousLogo)) {
                Storage::delete('public/images/' . $previousLogo);
            }

            $data['logo'] = $imageName;

            unset($data['card_id']);

            $card->update($data);

            return response([
                'status' => 'success',
                'data' => $card
            ], 200);

        }
        else {
            unset($data['card_id']);
            $card->update($data);

            return response([
                'status' => 'success',
                'data' => $card
            ], 200);
        }
    }

    public function deleteCard( Request $request )
    {
        Card::destroy($request->card_id);
        return response([
            'status' => 'success',
        ], 200);

    }

    public function listCards( Request $request )
    {
        $businessData = BusinessData::where('user_id', $request->user()->id)->first();

        //get cards that you created or cards that have your business ID
        $cards = Card::where('filler_id', $request->user()->id)
        ->orWhere('business_id', $businessData->id)
        ->get();

        return response([
            'status' => 'success',
            'cards' => $cards,
        ], 200);
    }
    public function listPublicCards( $id )
    {
        $businessData = BusinessData::where('user_id', $id)->first();

        //get cards that you created or cards that have your business ID
        $cards = Card::where('filler_id', $id)->get();

        return response([
            'status' => 'success',
            'cards' => $cards,
        ], 200);
    }

    public function getPublicCards()
    {
        $cards = Card::inRandomOrder()->take(6)->get();
        return response([
            'status' => 'success',
            'cards' => $cards,
        ], 200);
    }


}
