<?php

namespace App\Http\Controllers;

use App\Models\ManualTajiDeposit;
use App\Models\NairaWallet;
use App\Models\TajiriWallet;
use App\Models\TransactionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{
    public function getAllWallets(Request $request)
    {
        $id = $request->user()->id;

        $naira_wallet = NairaWallet::where('user_id', $id)->first();

        $tajiri_wallet = TajiriWallet::where('user_id', $id)->first();

        //transaction history and pending taji transactions
        $transactionHistory = TransactionLog::where('sender_id', $id)->orWhere('receiver_id', $id)->orderBy('created_at', 'desc')->take(15)->get();
        $manualTajiDeposits = ManualTajiDeposit::where('user_id', $id)->where('status', 'pending')->orderBy('created_at', 'desc')->get();

        return response([
            'naira_wallet' => $naira_wallet,
            'tajiri_wallet' => $tajiri_wallet,
            'transactionHistory' => $transactionHistory,
            'manualTajiDeposits' => $manualTajiDeposits
        ], 200);
    }

    public function depositNaira(Request $request, $ref)
    {
        //reference assignment
        //$ref = $request->ref;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
            'Cache-Control' => 'no-cache',
        ])->get('https://api.paystack.co/transaction/verify/' . rawurlencode($ref));

        if ($response->successful()) {
            //$responseData = $response->json();
            // Process the response data
            $err = false;
        } else {
            $err = $response->body();
            // Handle the error
        }

        if ($err) {
            return [
                'status' => 'fail',
                'message' => 'unable to verify payment'
            ];
        } else {

            $result = json_decode($response);
            if ($result->data->status == 'success') {

                $user_email = $result->data->customer->email;
                $user_id = $request->user()->id;

                //get the wallet of the guy we want to deposit for

                $customer_wallet = NairaWallet::where('user_id', $user_id)->first();

                $customer_wallet->increment('balance', $result->data->metadata->funds);


                $transactionData = [
                    'payment_method' => 'paystack',
                    'misc' => $response,
                    'sender_id' => 0,
                    'receiver_id' => $user_id,
                    'transaction_type' => 'Naira Deposit',
                    'amount' => $result->data->metadata->funds,
                    'currency' => 'naira'
                ];
                $storeTrans = TransactionLog::create($transactionData);




                return [
                    'status' => 'success',
                    'message' => 'payment verified',
                    'data' => $storeTrans
                ];
            } else {
                return [
                    'status' => 'fail',
                    'message' => 'unable to verify payment'
                ];
            }
        }
    }


    public function approveTajiriPayment(Request $request)
    {
        $pending_transaction_id = $request->transaction_id;

        $pending_transaction = ManualTajiDeposit::find($pending_transaction_id);

        //add that amount to the user's wallet
        $user_id = $pending_transaction->user_id;

        $tajiri_wallet = TajiriWallet::where('user_id', $user_id)->first();

        $tajiri_wallet->increment('balance', $pending_transaction->price);

        $transactionData = [
            'payment_method' => 'tajiri',
            'misc' => $pending_transaction,
            'sender_id' => 0,
            'receiver_id' => $user_id,
            'transaction_type' => 'Taji Deposit',
            'amount' => $pending_transaction->price,
            'currency' => 'tajiri'
        ];
        $storeTrans = TransactionLog::create($transactionData);

        $pending_transaction->update(['status' => 'accepted']);

        return [
            'status' => 'success',
            'message' => 'approval successful',
            'data' => $storeTrans
        ];
    }
}
