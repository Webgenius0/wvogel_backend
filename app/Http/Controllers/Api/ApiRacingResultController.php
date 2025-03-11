<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\RacingResult;
use Illuminate\Http\Request;

class ApiRacingResultController extends Controller
{
   public function index()
   {
    try{
        //here will be show the racing result for the user
        $racingResults = RacingResult::all();
        return ApiResponse::success(true, 200, 'Racing Results', $racingResults);
    }catch(\Exception $e){
        return ApiResponse::error(false, 500, $e->getMessage());
    }
   }
}
