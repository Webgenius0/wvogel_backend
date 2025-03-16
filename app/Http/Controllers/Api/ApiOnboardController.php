<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\onboard;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiOnboardController extends Controller
{
    public function onboarStoredData(Request $request)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();
            // Ensure a user is logged in
            if (!$user) {
                return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
            }
            // Validate incoming request data
            $validatedData = $request->validate([
                'most_share_race_horse' => 'nullable|string|max:255',
                'roi' => 'nullable|string|max:255',
                'horse_racing_risk_ownership' => 'nullable|string|max:255',
                'investment_opportunities' => 'nullable|string|max:255',
                'investment_venture' => 'nullable|string|max:255',
                'investment_venture_book' => 'nullable|string|max:255',
                'racing_potiential_profit' => 'nullable|string|max:255',
                'passive_investment' => 'nullable|string|max:255',
                'younger_experience' => 'nullable|string|max:255',
                'race_entery_fees' => 'nullable|string|max:255',
            ]);

            // Add the authenticated user's ID to the data
            $validatedData['user_id'] = $user->id;

            // Create and store onboard data
            $storeData = Onboard::create($validatedData);

            return response()->json(['status' => 'success', 'data' => $storeData], 201);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
