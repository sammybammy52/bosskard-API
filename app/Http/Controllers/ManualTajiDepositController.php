<?php

namespace App\Http\Controllers;

use App\Models\ManualTajiDeposit;
use Illuminate\Http\Request;

class ManualTajiDepositController extends Controller
{
    public function initializeManualTajiPayment(Request $request)
    {
        $file = $request->file('proof_of_payment');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/images', $fileName);

        $user_id = $request->user()->id;


        $data = [
            'user_id' => $user_id,
            'currency' => 'tajiri',
            'price' => $request->deposit,
            'proof_of_payment' => $fileName,
        ];
        $payment = ManualTajiDeposit::create($data);

        return $payment;
    }

    public function getAllManualPayments()
    {
        return ManualTajiDeposit::with('user')->where('status', 'pending')->orderBy('created_at', 'desc')->get();
    }

    public function userSpecificManualPayments(Request $request)
    {
        $id = $request->user()->id;

        return ManualTajiDeposit::where('user_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function rejectPaymentRequest($id)
    {
        $rejection = ManualTajiDeposit::find($id)->update(['status' => 'rejected']);

        return response('done', 200);
    }
}
