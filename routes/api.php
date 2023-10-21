<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessDataController;
use App\Http\Controllers\ManualTajiDepositController;
use App\Http\Controllers\PatchController;
use App\Http\Controllers\SocialsController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//patch routes
Route::get('/patch-all-wallets', [PatchController::class, 'patchAllWallets']);


//public routes

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
//get states and lga
Route::get('/client/state-and-lga', [StatesController::class, 'stateAndLga']);



// Route::post('/initialize-phone-verification', [VerificationController::class, 'initializePhoneVerification']);
// Route::post('/verify-phone', [VerificationController::class, 'verifyPhone']);

//protected routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/set-verify', [VerificationController::class, 'setVerifyPhone']);

    //create business account
    Route::post('/setup-business', [BusinessDataController::class, 'store']);
    //store social media accounts
    Route::post('/setup-socials', [SocialsController::class, 'store']);

    Route::post('/store-profile-info', [UserController::class, 'storeProfileInfo']);
    Route::post('/change-profile-pic', [UserController::class, 'changeProfilePic']);
    Route::get('/get-profile-info', [UserController::class, 'getProfileInfo']);

    Route::get('/get-all-wallets', [WalletController::class, 'getAllWallets']);

    Route::get('/deposit-naira/{ref}', [WalletController::class, 'depositNaira']);

    Route::post('/client/manual-taji-payment', [ManualTajiDepositController::class, 'initializeManualTajiPayment']);
    Route::get('/client/my-manual-payments', [ManualTajiDepositController::class, 'userSpecificManualPayments']);



    // Protected routes for admins
    Route::group(['middleware' => ['adminAuth']], function () {
        // Routes (only accessible by admins)

        //manual payments for admin side
        Route::get('/all-manual-taji-payments', [ManualTajiDepositController::class, 'getAllManualPayments']);
        //confirm the payment
        Route::post('/accept-taji-payment', [WalletController::class, 'approveTajiriPayment']);
        Route::get('/reject-taji-payment/{id}', [ManualTajiDepositController::class, 'rejectPaymentRequest']);
    });



    Route::post('/logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
