<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Race;
use Illuminate\Http\Request;

class ApiRaceController extends Controller
{
    public function index(){
        try {
            $races = Race::all();
            return ApiResponse::success(true, 200, 'Races fatched successfully', $races);
        } catch (\Exception $e) {
            return ApiResponse::error(false, 500, 'An error occurred', $e->getMessage());
        }
    }
}
