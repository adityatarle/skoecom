<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Razorpay\Api\Errors\BadRequestError;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page with improved cart validation and Razorpay setup
     */
    public function checkout()
    {
        try {
            $cart = session('cart', []);

            // Validate cart exists and has items
            if (empty($cart)) {
                Log::warning('Checkout attempted with empty cart.');
                return redirect()->route('cart.index')
                    ->with('error', 'Your cart is empty. Please add items before proceeding to checkout.');
            }

            // Calculate cart total from the current cart session
            $cartTotal = $this->calculateCartTotal($cart);

            // Validate minimum order amount
            if ($cartTotal < 1) {
                Log::warning('Checkout attempted with invalid cart total:', ['total' => $cartTotal]);
                return redirect()->route('cart.index')
                    ->with('error', 'Cart total must be at least ₹1.00 to proceed.');
            }

            // Store cart total in session for order processing
            session(['cart_total' => $cartTotal]);

            // Initialize Razorpay order
            $razorpayOrder = $this->createRazorpayOrder($cartTotal);

            // This should never be null now since we always return a fallback order
            if (!$razorpayOrder) {
                Log::error('Critical: Razorpay order creation returned null unexpectedly');
                return redirect()->route('cart.index')
                    ->with('error', 'Payment gateway initialization failed. Please try again.');
            }

            return view('checkout', compact('cart', 'cartTotal', 'razorpayOrder'));

        } catch (\Exception $e) {
            Log::error('Checkout page error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('cart.index')
                ->with('error', 'An error occurred while loading the checkout page. Please try again.');
        }
    }

    /**
     * Process the order placement with improved validation and error handling
     */
    public function placeOrder(Request $request)
    {
        Log::info('=== Place Order Started ===', [
            'user_id' => Auth::id(),
            'payment_method' => $request->payment_method
        ]);

        try {
            // Validate cart exists before processing
            $cart = session('cart', []);
            if (empty($cart)) {
                Log::error('Place order attempted with empty cart');
                return redirect()->route('cart.index')
                    ->with('error', 'Your cart is empty. Please add items before placing an order.');
            }

            // Create cart backup for recovery if needed
            session(['cart_backup' => $cart]);

            // Validate the request
            $validatedData = $this->validateOrderRequest($request);

            // Verify payment if Razorpay
            if ($validatedData['payment_method'] === 'razorpay') {
                $paymentVerified = $this->verifyRazorpayPayment($validatedData);
                if (!$paymentVerified) {
                    $this->restoreCart();
                    return redirect()->route('checkout')
                        ->with('error', 'Payment verification failed. Please try again.');
                }
            }

            // Calculate final order total
            $orderTotal = $this->calculateCartTotal($cart);
            if ($orderTotal <= 0) {
                Log::error('Invalid order total calculated', ['total' => $orderTotal]);
                $this->restoreCart();
                return redirect()->route('checkout')
                    ->with('error', 'Invalid order total. Please refresh and try again.');
            }

            // Create the order
            $order = $this->createOrder($validatedData, $cart, $orderTotal);

            if (!$order) {
                $this->restoreCart();
                return redirect()->route('checkout')
                    ->with('error', 'Failed to create order. Please try again.');
            }

            // Clear cart and related session data
            $this->clearCheckoutSession();

            Log::info('Order created successfully', ['order_id' => $order->id]);

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Your order has been placed successfully!');

        } catch (ValidationException $e) {
            Log::error('Order validation failed', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
                
        } catch (\Exception $e) {
            Log::error('Place order error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            $this->restoreCart();
            return redirect()->route('checkout')
                ->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    /**
     * Display a specific order
     */
    public function showOrder($orderId)
    {
        try {
            $query = Order::query();
            
            // Restrict access for logged-in users to their own orders
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            } else {
                // For guest orders, you might want to implement a token-based system
                // For now, redirect guests to login
                return redirect()->route('login')
                    ->with('error', 'Please log in to view your orders.');
            }

            $order = $query->findOrFail($orderId);
            return view('order_details', compact('order'));

        } catch (\Exception $e) {
            Log::error('Show order error: ' . $e->getMessage());
            return redirect()->route('orders.index')
                ->with('error', 'Order not found or access denied.');
        }
    }

    /**
     * Display user's order history
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please log in to view your order history.');
        }

        try {
            $orders = Order::where('user_id', Auth::id())
                           ->latest()
                           ->paginate(15);

            return view('orders.index', compact('orders'));

        } catch (\Exception $e) {
            Log::error('Orders index error: ' . $e->getMessage());
            return redirect()->route('home')
                ->with('error', 'Failed to load orders. Please try again.');
        }
    }

    /**
     * Apply coupon code
     */
    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code format.'
            ], 422);
        }

        // TODO: Implement coupon logic
        // For now, return a placeholder response
        return response()->json([
            'success' => false,
            'message' => 'Coupon system is currently under maintenance.'
        ]);
    }

    /**
     * Validate order request data
     */
    private function validateOrderRequest(Request $request)
    {
        return $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|in:cash_on_delivery,razorpay',
            'razorpay_payment_id' => 'required_if:payment_method,razorpay|nullable|string',
            'razorpay_order_id' => 'required_if:payment_method,razorpay|nullable|string',
            'razorpay_signature' => 'required_if:payment_method,razorpay|nullable|string',
        ]);
    }

    /**
     * Create Razorpay order
     */
    private function createRazorpayOrder($cartTotal)
    {
        $razorpayKey = env('RAZORPAY_KEY');
        $razorpaySecret = env('RAZORPAY_SECRET');

        // Check if keys are configured
        if (empty($razorpayKey) || empty($razorpaySecret) || 
            $razorpayKey === 'rzp_test_your_key_here' || 
            $razorpaySecret === 'your_secret_here') {
            
            Log::warning('Razorpay keys not configured properly', [
                'key_exists' => !empty($razorpayKey),
                'secret_exists' => !empty($razorpaySecret),
                'app_debug' => env('APP_DEBUG', false)
            ]);
            
            // Always create a demo order if keys are not configured
            $razorpayOrder = [
                'id' => 'order_demo_' . time(),
                'amount' => (int)($cartTotal * 100),
                'currency' => 'INR',
                'receipt' => 'DEMO_' . uniqid(),
                'status' => 'created'
            ];
            session(['razorpay_order_id' => $razorpayOrder['id']]);
            Log::info('Using demo Razorpay order', ['order_id' => $razorpayOrder['id']]);
            return $razorpayOrder;
        }

        try {
            $api = new Api($razorpayKey, $razorpaySecret);
            
            $razorpayOrderData = [
                'receipt' => 'ORD_' . uniqid() . '_' . time(),
                'amount' => (int)($cartTotal * 100),
                'currency' => 'INR',
                'payment_capture' => 1
            ];

            $razorpayOrder = $api->order->create($razorpayOrderData);
            session(['razorpay_order_id' => $razorpayOrder['id']]);
            
            Log::info('Razorpay order created', ['order_id' => $razorpayOrder['id']]);
            return $razorpayOrder;

        } catch (BadRequestError $e) {
            Log::error('Razorpay order creation failed', [
                'message' => $e->getMessage(),
                'field' => $e->getField()
            ]);
            
            // Fallback to demo order on API error
            $razorpayOrder = [
                'id' => 'order_fallback_' . time(),
                'amount' => (int)($cartTotal * 100),
                'currency' => 'INR',
                'receipt' => 'FALLBACK_' . uniqid(),
                'status' => 'created'
            ];
            session(['razorpay_order_id' => $razorpayOrder['id']]);
            Log::info('Using fallback Razorpay order due to API error', ['order_id' => $razorpayOrder['id']]);
            return $razorpayOrder;
            
        } catch (\Exception $e) {
            Log::error('Razorpay order creation error', ['message' => $e->getMessage()]);
            
            // Fallback to demo order on any error
            $razorpayOrder = [
                'id' => 'order_fallback_' . time(),
                'amount' => (int)($cartTotal * 100),
                'currency' => 'INR',
                'receipt' => 'FALLBACK_' . uniqid(),
                'status' => 'created'
            ];
            session(['razorpay_order_id' => $razorpayOrder['id']]);
            Log::info('Using fallback Razorpay order due to general error', ['order_id' => $razorpayOrder['id']]);
            return $razorpayOrder;
        }
    }

    /**
     * Verify Razorpay payment signature
     */
    private function verifyRazorpayPayment($validatedData)
    {
        if (env('APP_DEBUG', false) && 
            strpos($validatedData['razorpay_order_id'], 'order_demo_') === 0) {
            // Skip verification for demo orders in development
            Log::info('Skipping Razorpay verification for demo order');
            return true;
        }

        try {
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            
            $attributes = [
                'razorpay_order_id' => $validatedData['razorpay_order_id'],
                'razorpay_payment_id' => $validatedData['razorpay_payment_id'],
                'razorpay_signature' => $validatedData['razorpay_signature']
            ];

            $api->utility->verifyPaymentSignature($attributes);
            Log::info('Razorpay payment verified successfully');
            return true;

        } catch (SignatureVerificationError $e) {
            Log::error('Razorpay signature verification failed', ['message' => $e->getMessage()]);
            return false;
            
        } catch (\Exception $e) {
            Log::error('Razorpay verification error', ['message' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Create order in database
     */
    private function createOrder($validatedData, $cart, $orderTotal)
    {
        try {
            $orderData = [
                'user_id' => Auth::id(),
                'products' => $cart,
                'total_price' => $orderTotal,
                'status' => ($validatedData['payment_method'] === 'razorpay') ? 'paid' : 'pending',
                'first_name' => $validatedData['first_name'],
                'last_name' => $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'street_address' => $validatedData['street_address'],
                'city' => $validatedData['city'],
                'state' => $validatedData['state'],
                'country' => $validatedData['country'],
                'payment_method' => $validatedData['payment_method'],
                'razorpay_payment_id' => $validatedData['razorpay_payment_id'] ?? null,
                'razorpay_order_id' => $validatedData['razorpay_order_id'] ?? null,
            ];

            $order = Order::create($orderData);
            Log::info('Order created in database', ['order_id' => $order->id]);
            
            return $order;

        } catch (\Exception $e) {
            Log::error('Order creation failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Calculate cart total
     */
    private function calculateCartTotal($cart)
    {
        return collect($cart)->sum(fn($product) => 
            ($product['price'] ?? 0) * ($product['quantity'] ?? 0)
        );
    }

    /**
     * Restore cart from backup
     */
    private function restoreCart()
    {
        $backup = session('cart_backup', []);
        if (!empty($backup)) {
            session(['cart' => $backup]);
            Log::info('Cart restored from backup');
        }
    }

    /**
     * Reorder items from a previous order
     */
    public function reorder(Request $request, $orderId)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please log in to reorder items.'
                ], 401);
            }

            $order = Order::where('user_id', Auth::id())->findOrFail($orderId);
            
            if (!is_array($order->products) || empty($order->products)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No items found in this order to reorder.'
                ], 400);
            }

            $cart = session('cart', []);
            $addedItems = 0;

            foreach ($order->products as $productId => $productData) {
                // Verify product still exists and is available
                $product = Product::find($productId);
                if (!$product) {
                    continue; // Skip if product no longer exists
                }

                $quantity = $productData['quantity'] ?? 1;
                
                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += $quantity;
                } else {
                    $cart[$productId] = [
                        "name" => $product->name,
                        "price" => $product->price,
                        "image" => $product->images->first()?->image_path ?? 'images/no-image.png',
                        "quantity" => $quantity
                    ];
                }
                $addedItems++;
            }

            if ($addedItems === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No items could be added to cart. Products may no longer be available.'
                ], 400);
            }

            session(['cart' => $cart]);

            return response()->json([
                'success' => true,
                'message' => "{$addedItems} item(s) added to your cart successfully!",
                'cart_count' => count($cart),
                'redirect_url' => route('cart.index')
            ]);

        } catch (\Exception $e) {
            Log::error('Reorder error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reorder items. Please try again.'
            ], 500);
        }
    }

    /**
     * Clear checkout-related session data
     */
    private function clearCheckoutSession()
    {
        session()->forget([
            'cart', 
            'cart_total', 
            'cart_backup', 
            'razorpay_order_id'
        ]);
        Log::info('Checkout session data cleared');
    }
}