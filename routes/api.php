<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessDataController;
use App\Http\Controllers\CardsController;
use App\Http\Controllers\ExploreBusinessesController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LikedItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ManualTajiDepositController;
use App\Http\Controllers\PatchController;
use App\Http\Controllers\PublicUploadController;
use App\Http\Controllers\SocialsController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\WebsiteController;
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
// Route::get('/patch-all-wallets', [PatchController::class, 'patchAllWallets']);


//alternate image route
Route::get('/alt-image-route/{filename}', [ImageController::class, 'getImages']);

Route::get('/get-public-cards/{id}', [CardsController::class, 'listPublicCards']);

Route::get('/get-public-cards', [CardsController::class, 'getPublicCards']);

Route::get('/get-cards-by-country/{country_id}', [CardsController::class, 'getCardsByCountry']);

Route::get('/get-cards-by-category/{category_id}', [CardsController::class, 'getCardsByCategory']);
Route::post('/client/filter-search-cards', [CardsController::class, 'filterSearch']);




//public routes

//public image upload
Route::post('/public-upload', [PublicUploadController::class, 'uploadImage']);


Route::post('/register', [AuthController::class, 'register']);


Route::post('/login', [AuthController::class, 'login']);
//get states and lga
Route::get('/client/get-countries', [LocationController::class, 'getCountries']);
Route::get('/client/get-westafrican-countries', [LocationController::class, 'getWestAfricanCountries']);
Route::get('/client/get-states/{country_id}', [LocationController::class, 'getStates']);
Route::get('/client/get-cities/{country_id}/{state_id}', [LocationController::class, 'getCities']);

//get currencies for countries
Route::get('/client/get-currencies', [LocationController::class, 'getCurrencies']);

//get business category list
Route::get('/client/get-business-category-list', [BusinessDataController::class, 'getBusinessCategoryList']);

//featured data for the explore businesses page

Route::get('/client/explore-featured-data', [ExploreBusinessesController::class, 'exploreFeaturedData']);

//get businesses by categories
Route::get('/client/get-businesses-by-category/{category_id}', [ExploreBusinessesController::class, 'getBusinessesByCategory']);

//get businesses by state
Route::get('/client/get-businesses-by-state/{state_id}', [ExploreBusinessesController::class, 'getBusinessesByState']);

//client filter search
Route::post('/client/filter-search', [ExploreBusinessesController::class, 'filterSearch']);

//client fetch business details
Route::get('/client/public-business-page/{id}', [ExploreBusinessesController::class, 'publicBusinessPage']);

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

    //business cards
    Route::post('/create-card', [CardsController::class, 'createCard']);
    Route::post('/edit-card', [CardsController::class, 'editCard']);
    Route::post('/delete-card', [CardsController::class, 'deleteCard']);
    Route::get('/list-cards', [CardsController::class, 'listCards']);
    //like cards
    Route::get('/like-card/{card_id}', [LikedItemController::class, 'likeCard']);

    Route::get('/get-liked-cards', [CardsController::class, 'getLikedCards']);

    //update bio

    Route::post('/update-bio', [BusinessDataController::class, 'updateBio']);

    //website setup

    Route::post('/update-website', [WebsiteController::class, 'updateWebsite']);





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
