<?php

use App\Http\Controllers\AuthController;
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

Route::get('/set-verify/{id}',[VerificationController::class,'setVerifyPhone']);

// Route::post('/initialize-phone-verification', [VerificationController::class, 'initializePhoneVerification']);
// Route::post('/verify-phone', [VerificationController::class, 'verifyPhone']);

//protected routes

Route::group(['middleware' => ['auth:sanctum']], function () {

    //create blog route
    Route::post('/blog/store', [BlogController::class,'store']);
    //edit blog route
    Route::post('/blog/update', [BlogController::class, 'update']);

    //delete blog route
    Route::get('/blog/delete/{id}',[BlogController::class,'destroy']);

    //set top story
    Route::get('/set-top/{id}',[BlogController::class,'setTopStory']);

    //discover Routes
    Route::post('/discover/store', [DiscoverController::class,'store']);

    Route::get('/discover/delete/{id}', [DiscoverController::class,'delete']);


    Route::post('/logout', [AuthController::class, 'logout']);


});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
