<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Horses;
use Illuminate\Http\Request;

class ApiHorseController   extends Controller
{
    public function index(Request $request) {
        try {
            // Get category name from request
            $categoryName = $request->query('category_name');

            // Fetch horses with category relation
            $query = Horses::with('category');

            // Filter by category name if provided
            if ($categoryName) {
                $query->whereHas('category', function ($q) use ($categoryName) {
                    $q->where('category_name', $categoryName);
                });
            }

            // Paginate the results (10 per page)
            $horses = $query->get();

            return ApiResponse::success(true, 200, 'Horses fetched successfully', $horses);

        } catch (\Exception $e) {
            return ApiResponse::error(false, 500, 'An error occurred', $e->getMessage());
        }
    }

   public function show($id) {
    try {
        $horse=Horses::with('category')->findOrFail($id);
        return ApiResponse::success(true, 200, 'Horse fatched successfully', $horse);
    } catch (\Exception $e) {
        return ApiResponse::error( 500, 'Horse not found', $e->getMessage());
    }
   }
}
