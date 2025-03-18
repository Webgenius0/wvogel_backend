<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Horses;
use App\Models\HorseShareForSale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Validator;

class ApiStripePaymentController extends Controller
{
    public function createPayment(Request $request)
{
    // Validate request
    $validator = Validator::make($request->all(), [
        'horses' => 'required|array',
        'horses.*.horse_id' => 'required|exists:horses,id',
        'horses.*.ownership_share' => 'required|string|max:255',
        'horses.*.price' => 'required|integer',
        'total_price' => 'required|integer',
        'status' => 'in:pending,success',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Insert horse shares into the database
    $horseShares = [];
    foreach ($request->horses as $horseData) {
        $horse = Horses::find($horseData['horse_id']);

        if (!$horse) {
            return response()->json([
                'status' => 'error',
                'message' => "Horse with ID {$horseData['horse_id']} not found.",
            ], 404);
        }

        $horseShares[] = [
            'user_id' => Auth::user()->id,
            'horse_id' => $horseData['horse_id'],
            'category_id' => $horse->category_id, // Fetch category dynamically
            'ownership_share' => $horseData['ownership_share'],
            'sub_total_price' => $horseData['price'],
            'total_price' => $request->total_price,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    HorseShareForSale::insert($horseShares);

    // Stripe setup
    Stripe::setApiKey(env('STRIPE_SECRET'));

    try {
        $lineItems = [];
        foreach ($request->horses as $horseData) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Horse Share - ID ' . $horseData['horse_id'],
                    ],
                    'unit_amount' => $horseData['price'] * 100, // Amount in cents
                ],
                'quantity' => 1,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.payment.cancel'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Payment initiated successfully.',
            'checkout_url' => $session->url,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Payment initiation failed',
            'error' => $e->getMessage(),
        ], 400);
    }
}


    // Success callback
    public function success(Request $request)
    {
        // Fetch session ID from the request
        $sessionId = $request->get('session_id');

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            // Retrieve the session from Stripe
            $session = Session::retrieve($sessionId);

            // Update the horse shares status based on the successful payment
            $horseShares = HorseShareForSale::where('paypal_payment_id', $session->id)->get();

            if ($horseShares->isEmpty()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No matching horse shares found for this session.',
                ], 404);
            }

            foreach ($horseShares as $horseShare) {
                $horseShare->status = 'success';
                $horseShare->save();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Payment captured successfully.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error capturing payment',
                'error' => $e->getMessage(),
            ], 400);
        }
    }

    // Cancel callback
    public function cancel(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Payment canceled.',
        ], 200);
    }
}

