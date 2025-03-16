<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class ArtisanCommandController extends Controller
{
    public function RunMigrations(): JsonResponse {
        try {
            Artisan::call('migrate:fresh --seed');
            Artisan::call('optimize:clear');
            return response()->json(['success' => true, 'message' => 'Migrations and seeds have been run successfully.'], 200);
        } catch (Exception $e) {
            Log::error('Error resetting system: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Error resetting system: ' . $e->getMessage()], 500);
        }
    }

    public function strogelink(): JsonResponse {
        try {
            Artisan::call('app:strogelink-command'); // Correct command name
            return response()->json(['success' => true, 'message' => 'Strogelink has been run successfully.'], 200);
        } catch (Exception $e) {
            Log::error('Error running strogelink: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'message' => 'Error running strogelink: ' . $e->getMessage()], 500);
        }
    }
    


}
