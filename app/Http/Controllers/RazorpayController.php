<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\BadRequestError;
use Illuminate\Support\Facades\Log;
use Session;

class RazorpayController extends Controller
{
    /**
     * Test Razorpay configuration
     */
    public function testConfig()
    {
        $razorpayKey = env('RAZORPAY_KEY');
        $razorpaySecret = env('RAZORPAY_SECRET');
        
        if (empty($razorpayKey) || empty($razorpaySecret) || 
            $razorpayKey === 'rzp_test_your_key_here' || 
            $razorpaySecret === 'your_secret_here') {
            return response()->json([
                'status' => 'error',
                'message' => 'Razorpay keys not configured properly',
                'debug' => [
                    'key_set' => !empty($razorpayKey),
                    'secret_set' => !empty($razorpaySecret),
                    'key_is_placeholder' => $razorpayKey === 'rzp_test_your_key_here'
                ]
            ]);
        }

        try {
            $api = new Api($razorpayKey, $razorpaySecret);
            
            // Test with minimal order creation
            $testOrder = [
                'receipt' => 'TEST_' . time(),
                'amount' => 100, // ₹1.00 in paise
                'currency' => 'INR',
                'payment_capture' => 1
            ];
            
            $order = $api->order->create($testOrder);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Razorpay configuration is working',
                'order_id' => $order['id']
            ]);
            
        } catch (BadRequestError $e) {
            Log::error('Razorpay Test Config Error:', [
                'message' => $e->getMessage(),
                'field' => $e->getField(),
                'code' => $e->getCode()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Razorpay API Error: ' . $e->getMessage(),
                'field' => $e->getField(),
                'code' => $e->getCode()
            ]);
        } catch (\Exception $e) {
            Log::error('Razorpay Test General Error:', ['message' => $e->getMessage()]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'General Error: ' . $e->getMessage()
            ]);
        }
    }

    public function createOrder()
    {
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

            $order = $api->order->create([
                'receipt' => 'ORD_'.rand(10000,99999),
                'amount' => 50000, // Amount in paise (INR 500)
                'currency' => 'INR',
                'payment_capture' => 1,
            ]);

            return response()->json($order);
        } catch (BadRequestError $e) {
            Log::error('Razorpay Order Creation Error:', [
                'message' => $e->getMessage(),
                'field' => $e->getField(),
                'code' => $e->getCode()
            ]);
            
            return response()->json([
                'error' => true,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            Log::error('Razorpay General Error:', ['message' => $e->getMessage()]);
            
            return response()->json([
                'error' => true,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            return redirect()->route('checkout.success')->with('success', 'Payment Successful!');
        } catch (\Exception $e) {
            Log::error('Payment Verification Error:', ['message' => $e->getMessage()]);
            return redirect()->route('checkout')->with('error', 'Payment Verification Failed!');
        }
    }
}
