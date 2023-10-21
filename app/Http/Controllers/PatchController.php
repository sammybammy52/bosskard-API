<?php

namespace App\Http\Controllers;

use App\Models\NairaWallet;
use App\Models\TajiriWallet;
use App\Models\User;
use Illuminate\Http\Request;

class PatchController extends Controller
{
    public function patchAllWallets()
    {
        // create naira and taji wallet for all existing users
        $users = User::all();

        foreach ($users as $user) {
            $nairaWalletData = [
                'balance' => 0,
                'user_id' => $user->id,
            ];
            NairaWallet::create($nairaWalletData);

            $tajiriWalletData = [
                'balance' => 0,
                'user_id' => $user->id,
            ];

            TajiriWallet::create($tajiriWalletData);
        }

        return [
          'message' => 'patched all wallets'
        ];
    }
}
