<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        // Ensure the incoming request is valid
        $validator = Validator::make($request->all(), [
            'horse_ids' => 'required|array',
            'horse_ids.*' => 'exists:horses,id',
            'category_id' => 'required|exists:categories,id',
            'ownership_share' => 'required|string|max:255',
            'sub_total_price' => 'required|integer',
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

        // Add the horses to the database
        $horseShares = [];
        foreach ($request->horse_ids as $horseId) {
            $horseShares[] = [
                'user_id' => Auth::user()->id,
                'horse_id' => $horseId,
                'category_id' => $request->category_id,
                'ownership_share' => $request->ownership_share,
                'sub_total_price' => $request->sub_total_price,
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
            // Create a new Checkout Session for the payment
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Horse Shares',
                            ],
                            'unit_amount' => $request->total_price * 100,  // Amount in cents
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('stripe.payment.cancel'),
            ]);

            // Redirect user to Stripe Checkout page
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

