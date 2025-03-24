<?php

use App\Http\Controllers\Api\ApiEventController;
use App\Http\Controllers\Api\ApiGroupChatController;
use App\Http\Controllers\Api\ApiGroupController;
use App\Http\Controllers\Api\ApiHorseController;
use App\Http\Controllers\Api\ApiHorseShareForSaleController;
use App\Http\Controllers\Api\ApiMessageController;
use App\Http\Controllers\Api\ApiNotificationController;
use App\Http\Controllers\Api\ApiOnboardController;
use App\Http\Controllers\Api\ApiRaceController;
use App\Http\Controllers\Api\ApiRacingResultController;
use App\Http\Controllers\Api\ApiStripePaymentController;
use App\Http\Controllers\Api\ApiWinChampionController;
use App\Http\Controllers\Api\auth\LoginController;
use App\Http\Controllers\Api\auth\ProfileUpdateController;
use App\Http\Controllers\Api\auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiEquibaseTrainerProfileDataController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/user-info', [ProfileUpdateController::class, 'index']);
Route::post('/update-user-info/{id}', [ProfileUpdateController::class, 'updateProfile']);
// Route::post('/update-user-password/{id}', [ProfileUpdateController::class, 'updatePassword']);
Route::middleware('auth:api')->post('update-user-password/{id}', [ProfileUpdateController::class, 'updatePassword']);


//horse  methods
Route::controller(ApiHorseController::class)->group(function (){
    Route::get('horse', 'index');
    Route::get('horse/{id}', 'show');
});

Route::controller(ApiRaceController::class)->group(function () {
    Route::get('race', 'index');
});

//Win champion methods
Route::controller(ApiWinChampionController::class)->group(function () {
    Route::get('win-champion', 'index');

});
//event methods
Route::controller(ApiEventController::class)->group(function () {
    Route::get('event', 'index');
});
//Racing result methods
Route::controller(ApiRacingResultController::class)->group(function () {
    Route::get('racing-result', 'index');
    Route::get('scaping-data','scaping');
});

// Chat messages methods
Route::middleware('auth:api')->group(function () {
    Route::get('/messages', [ApiMessageController::class, 'index'] );
    Route::post('/messages/send', [ApiMessageController::class, 'sendMessage']);
    Route::get('/messages/{userId}', [ApiMessageController::class, 'getMessages']);
    Route::get('/chat-users', [ApiMessageController::class, 'getChatUsers']);
});
//group chat methods


Route::middleware('auth:api')->group(function () {
    Route::post('/group/create', [ApiGroupController::class, 'createGroup']);
    Route::post('/group/{id}/add-member', [ApiGroupController::class, 'addMember']);

    Route::post('/group/{id}/message', [ApiGroupChatController::class, 'sendMessage']);
    Route::get('/group/{id}/messages', [ApiGroupChatController::class, 'fetchMessages']);
});
//Chat notifications methods
Route::middleware('auth:api,role:user')->group(function () {
    Route::get('notifications', [ApiNotificationController::class, 'index']);
    Route::get('notifications/{id}', [ApiNotificationController::class, 'read']);
});




//Horse sale methods with paypal

Route::middleware(['auth:api, role:user'])->group(function () {
    // Route::get('/horse-share-for-sale', [ApiHorseShareForSaleController::class, 'index']);
    Route::post('/paypal/horse-share-for-sale', [ApiHorseShareForSaleController::class, 'store']);
});
Route::get('/paypal/payment/success', [ApiHorseShareForSaleController::class, 'success'])->name('paypal.payment.success');
Route::get('/paypal/payment/cancel', [ApiHorseShareForSaleController::class, 'cancel'])->name('paypal.payment.cancel');

//Horse sale methods with stripe

Route::middleware(['auth:api, role:user'])->group(function () {
    // Route::get('/horse-share-for-sale', [ApiHorseShareForSaleController::class, 'index']);
    Route::post('/stripe/horse-share-for-sale', [ApiStripePaymentController::class, 'createPayment']);
});
Route::get('/stripe/payment/success', [ApiStripePaymentController::class,'success'])->name('stripe.payment.success');
Route::get('/stripe/payment/cancel', [ApiStripePaymentController::class,'cancel'])->name('stripe.payment.cancel');

//Onboard data method

Route::middleware(['auth:api, role:user'])->group(function () {
    Route::post('/onboard-data', [ApiOnboardController::class, 'onboarStoredData']);
});


Route::get('/equibase/trainer-Profile', [ApiEquibaseTrainerProfileDataController::class,'getScapingdata'])->name('equibase.trainer_profile.data');
