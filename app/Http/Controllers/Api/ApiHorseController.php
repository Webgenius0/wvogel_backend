<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Horses;
use Illuminate\Http\Request;

class ApiHorseController   extends Controller
{
   public function index() {

    try {
        $horse=Horses::all();
        return ApiResponse::success(true, 200, 'Horse fatched successfully', $horse);

    } catch (\Exception $e) {
        return ApiResponse::error(false, 500, 'An error occurred', $e->getMessage());
    }
   }
   public function show($id) {
    try {
        $horse=Horses::findOrFail($id);
        return ApiResponse::success(true, 200, 'Horse fatched successfully', $horse);
    } catch (\Exception $e) {
        return ApiResponse::error( 500, 'Horse not found', $e->getMessage());
    }
   }
}
