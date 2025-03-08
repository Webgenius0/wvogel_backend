<?php

use App\Http\Controllers\ArtisanCommandController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/',function (){
    if (Auth::check()){
        return redirect()->route('dashboard');
    }else{
        return redirect()->route('login');
    }
});

Route::get('/reset', [ArtisanCommandController::class, 'RunMigrations'])->name('reset');
Route::get('/strogelink', [ArtisanCommandController::class, 'strogelink'])->name('strogelink');

Route::get('/user-dashboard', function () {
    return view ('dashboard');
})->middleware(['auth', 'verified'])->name('user.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
require __DIR__.'/channels.php';

