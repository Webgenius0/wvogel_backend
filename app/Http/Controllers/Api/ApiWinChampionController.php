<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\WinChampion;
use Illuminate\Http\Request;

class ApiWinChampionController extends Controller
{
    public function index(){
        try{
            $winChampion = WinChampion::all();
            return ApiResponse::success(true,200,'Win champion fatched successfully', $winChampion);
        }catch(\Exception $e){
            return ApiResponse::error(false,500,'An error occurred', $e->getMessage());
        }
    }
}
