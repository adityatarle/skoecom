<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Session;

class RazorpayController extends Controller
{
    public function createOrder()
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => 'ORD_'.rand(10000,99999),
            'amount' => 50000, // Amount in paise (INR 500)
            'currency' => 'INR',
            'payment_capture' => 1,
        ]);

        return response()->json($order);
    }

    public function paymentSuccess(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        
        try {
            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            return redirect()->route('checkout.success')->with('success', 'Payment Successful!');
        } catch (\Exception $e) {
            return redirect()->route('checkout')->with('error', 'Payment Verification Failed!');
        }
    }
}
