<?php

use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\EventController;
use App\Http\Controllers\Web\Backend\HorsesController;
use App\Http\Controllers\Web\Backend\PaymetHistoryController;
use App\Http\Controllers\Web\Backend\RaceController;
use App\Http\Controllers\Web\Backend\Settings\DynamicPageController;
use App\Http\Controllers\Web\Backend\Settings\MailSettingController;
use App\Http\Controllers\Web\Backend\Settings\ProfileController;
use App\Http\Controllers\Web\Backend\Settings\StripeSettingController;
use App\Http\Controllers\Web\Backend\Settings\SystemSettingController;
use App\Http\Controllers\Web\Backend\WinChampionController;
use Illuminate\Support\Facades\Route;

//! Route for Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//! Route for Profile Settings
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'index')->name('profile.setting');
    Route::patch('/update-profile', 'UpdateProfile')->name('update.profile');
    Route::put('/update-profile-password', 'UpdatePassword')->name('update.Password');
    Route::post('/update-profile-picture', 'UpdateProfilePicture')->name('update.profile.picture');
});

//! Route for System Settings
Route::controller(SystemSettingController::class)->group(function () {
    Route::get('/system-setting', 'index')->name('system.index');
    Route::patch('/system-setting', 'update')->name('system.update');
});

//! Route for Horse
Route::controller(HorsesController::class)->group(function (){
    Route::get('/horse', 'index')->name('horse.index');
    Route::get('/horse/create', 'create')->name('horse.create');
    Route::post('/horse', 'store')->name('horse.store');
    Route::get('/horse/{id}/edit', 'edit')->name('horse.edit');
    Route::put('/horse/{id}', 'update')->name('horse.update');
    Route::delete('/horse/{id}', 'destroy')->name('horse.destroy');

});

//! Route for Horse Race
Route::controller(RaceController::class)->group(function () {
    Route::get('/horse-race', 'index')->name('race.index');
    Route::get('/horse-race/create', 'create')->name('race.create');
    Route::post('/horse-race', 'store')->name('race.store');
    Route::get('/horse-race/{id}/edit', 'edit')->name('race.edit');
    Route::put('/horse-race/{id}', 'update')->name('race.update');
    Route::delete('/horse-race/{id}', 'destroy')->name('race.destroy');
});

//!Route for Win Championship
Route::controller(WinChampionController::class)->group(function () {
    Route::get('/win-champion', 'index')->name('winchampion.index');
    Route::get('/win-champion/create', 'create')->name('winchampion.create');
    Route::post('/win-champion', 'store')->name('winchampion.store');
    Route::get('/win-champion/{id}/edit', 'edit')->name('winchampion.edit');
    Route::put('/win-champion/{id}', 'update')->name('winchampion.update');
    Route::delete('/win-champion/{id}', 'destroy')->name('winchampion.destroy');
});

//! Route for event settings
Route::controller(EventController::class)->group(function () {
    Route::get('/event', 'index')->name('event.index');
    Route::get('/event/create', 'create')->name('event.create');
    Route::post('/event', 'store')->name('event.store');
    Route::get('/event/{id}/edit', 'edit')->name('event.edit');
    Route::put('/event/{id}', 'update')->name('event.update');
    Route::delete('/event/{id}', 'destroy')->name('event.destroy');
});


//! Route for payment methods
Route::controller(PaymetHistoryController::class)->group(function () {
    Route::get('/payment-history', 'index')->name('payment.index');
    Route::delete('/payment-history/{id}', 'destroy')->name('payment.destroy');
});
