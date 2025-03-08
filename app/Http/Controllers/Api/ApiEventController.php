<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class ApiEventController extends Controller
{
  public function index()
  {
    try {
        $events = Event::all();
        if (!$events) {
            return ApiResponse::error(false, 'Events not found', 404, 'Events not found');
        }
        return ApiResponse::success(true, 200, 'Events fatched successfully', $events);
    } catch (\Exception $e) {
        return ApiResponse::error(false, 'Something went wrong', 500, $e->getMessage());
    }
  }
}
