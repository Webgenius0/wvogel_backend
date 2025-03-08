<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\HorseShareForSale;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Validation\ValidationException;

class ApiHorseShareForSaleController extends Controller
{
    public function index(){
        try {
            $horseForSales = HorseShareForSale::all();
            return ApiResponse::success(200, 'Horses for sale fetched successfully', $horseForSales);
        } catch (\Exception $e) {
            return ApiResponse::error(500, 'An error occurred', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'horse_id' => 'required|exists:horses,id',
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

        // Create a new HorseShareForSale record
        $horseShare = HorseShareForSale::create([
            'user_id' => $user->id,
            'horse_id' => $request->horse_id,
            'ownership_share' => $request->ownership_share,
            'sub_total_price' => $request->sub_total_price,
            'total_price' => $request->total_price,
            'status' => 'pending',
        ]);

        // Initiate PayPal payment
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $payment = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $request->total_price,
                    ],
                ],
            ],
            'application_context' => [
                'return_url' => route('payment.success'),
                'cancel_url' => route('payment.cancel'),
            ],
        ]);

        if (isset($payment['id']) && $payment['id'] != null) {
            foreach ($payment['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    // Save the PayPal payment ID to the horse share record
                    $horseShare->paypal_payment_id = $payment['id'];
                    $horseShare->save();

                    // Redirect the user to the PayPal approval URL
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Payment initiated successfully.',
                        'approval_url' => $link['href'],
                    ], 200);
                }
            }
        } else {
            Log::error('Payment failed', ['payment' => $payment]);
            return response()->json([
                'status' => 'error',
                'message' => 'Payment initiation failed.',
                'response' => $payment,
            ], 400);
        }
    }

    public function success(Request $request)
    {
        dd('Payment initiated successfully'. $request->all());
        Log::info("success url call", $request->all());
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        // Capture payment
        $payment = $provider->capturePaymentOrder($request->token);

        // Check if payment ID exists
        if (!isset($payment['id'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Payment ID not found in PayPal response',
                'response' => $payment,
            ], 400);
        }

        // Find the horse share
        $horseShare = HorseShareForSale::where('paypal_payment_id', $payment['id'])->first();

        if (!$horseShare) {
            return response()->json([
                'status' => 'error',
                'message' => 'No matching horse share found for this payment ID',
                'payment_id' => $payment['id'],
            ], 404);
        }

        // Update status
        $horseShare->status = 'success';
        $horseShare->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment captured successfully.',
        ], 200);
    }

    public function cancel(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Payment canceled.',
        ], 200);
    }
}
