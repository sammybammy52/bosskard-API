<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessDataController;
use App\Http\Controllers\SocialsController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\VerificationController;
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

//public routes

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
//get states and lga
Route::get('/client/state-and-lga', [StatesController::class, 'stateAndLga']);



// Route::post('/initialize-phone-verification', [VerificationController::class, 'initializePhoneVerification']);
// Route::post('/verify-phone', [VerificationController::class, 'verifyPhone']);

//protected routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/set-verify',[VerificationController::class,'setVerifyPhone']);

    //create business account
    Route::post('/setup-business', [BusinessDataController::class,'store']);
    //store social media accounts
    Route::post('/setup-socials', [SocialsController::class,'store']);




    Route::post('/logout', [AuthController::class, 'logout']);


});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
