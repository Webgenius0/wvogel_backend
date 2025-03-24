<?php

use App\Http\Controllers\Api\ApiEquibaseTrainerProfileDataController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;


// Schedule::call(function () {
//     Log::info("schedule runing message");
// })->everySecond();


Schedule::call(function () {
    Log::info("scrape schedule runing ");
    // Use the service container to resolve the controller with dependencies
    app(ApiEquibaseTrainerProfileDataController::class)->scrape();
})->everyTwoHours(); // Change frequency as needed
