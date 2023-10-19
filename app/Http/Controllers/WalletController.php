<?php

namespace App\Http\Controllers;

use App\Models\NairaWallet;
use App\Models\TajiriWallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function getAllWallets(Request $request)
    {
        $id = $request->user()->id;

        $naira_wallet = NairaWallet::where('user_id', $id)->first();

        $tajiri_wallet = TajiriWallet::where('user_id', $id)->first();



        return response([
            'naira_wallet' => $naira_wallet,
            'tajiri_wallet' => $tajiri_wallet,
        ], 200);
    }
}
