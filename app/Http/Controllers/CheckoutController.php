<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Make sure your Order model namespace is correct
use App\Models\User;  // Assuming you have a User model
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use Razorpay\Api\Errors\BadRequestError;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException; // Add this use statement

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     * Creates a Razorpay order ID beforehand.
     */
    public function checkout()
    {
        $cart = session('cart', []);

        // Log cart data on checkout page load
        Log::info('Checkout Page Load - Session Data:', ['cart' => $cart, 'cart_total' => session('cart_total')]);

        if (empty($cart)) {
            Log::warning('Checkout attempted with empty cart.');
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before proceeding to checkout.');
        }

        // Calculate cart total from the current cart session
        $cartTotal = collect($cart)->sum(fn($product) => ($product['price'] ?? 0) * ($product['quantity'] ?? 0));
        session(['cart_total' => $cartTotal]); // Update session total

        // Ensure cart total is valid for Razorpay (minimum INR 1.00)
        if ($cartTotal < 1) {
            Log::warning('Checkout attempted with invalid cart total:', ['total' => $cartTotal]);
            return redirect()->route('cart.index')->with('error', 'Cart total must be at least ₹1.00 to proceed.');
        }

        // Initialize Razorpay API
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // Prepare Razorpay order data
        $razorpayOrderData = [
            'receipt'         => 'ORD_' . uniqid(), // Generate a unique receipt ID
            'amount'          => $cartTotal * 100, // Amount in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // Auto-capture payment
        ];

        Log::info('Attempting to create Razorpay order with data:', $razorpayOrderData);

        // Create Razorpay order
        try {
            $razorpayOrder = $api->order->create($razorpayOrderData);
            Log::info('Razorpay order created successfully:', ['order_id' => $razorpayOrder['id']]);
            session(['razorpay_order_id' => $razorpayOrder['id']]); // Store Razorpay order ID in session

        } catch (BadRequestError $e) {
            Log::error('Razorpay API Bad Request Error (Order Creation):', ['message' => $e->getMessage(), 'field' => $e->getField(), 'code' => $e->getCode()]);
            return redirect()->route('cart.index')->with('error', 'Failed to initialize payment gateway. Please check your cart or try again later.');
        } catch (\Exception $e) {
            Log::error('General Error creating Razorpay order:', ['message' => $e->getMessage()]);
            return redirect()->route('cart.index')->with('error', 'An unexpected error occurred while preparing your order. Please try again.');
        }

        // Pass necessary data to the checkout view
        return view('checkout', compact('cart', 'cartTotal', 'razorpayOrder'));
    }


    /**
     * Process the order placement after form submission.
     * Handles both Cash on Delivery and Razorpay payments.
     */
    public function placeOrder(Request $request)
    {
        // Log point 1: Raw Request Data (BEFORE anything else)
        Log::info('=== placeOrder START ===');
        Log::info('Incoming Request Data:', $request->all());

        // Log point 2: Session Cart Data (Check immediately)
        $cart = session('cart', []); // Get cart directly from session
        Log::info('Cart Data Found in Session:', ['cart_empty' => empty($cart), 'cart_keys' => empty($cart) ? [] : array_keys($cart)]);

        if (empty($cart)) {
            Log::error('CRITICAL: Cart is empty at the very start of placeOrder. Session likely lost.');
            return redirect()->route('cart.index')->with('error', 'Your session expired or cart is empty. Please add items again.');
        }

        // Backup cart immediately (in case validation fails and we need to redirect back)
        session()->put('cart_backup', $cart);
        Log::info('Cart backup created.');

        // Log point 3: Validation Attempt
        Log::info('Attempting validation...');
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20', // Adjust max length as needed
                'street_address' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'state' => 'required|string|max:100',
                'country' => 'required|string|max:100',
                'payment_method' => 'required|in:cash_on_delivery,razorpay',
                'razorpay_payment_id' => 'required_if:payment_method,razorpay|nullable|string',
                'razorpay_order_id' => 'required_if:payment_method,razorpay|nullable|string',
                'razorpay_signature' => 'required_if:payment_method,razorpay|nullable|string',
            ]);
            Log::info('Validation PASSED.');

        } catch (ValidationException $e) {
            Log::error('Validation FAILED:', ['errors' => $e->errors(), 'input' => $request->except('password', 'password_confirmation')]); // Don't log passwords
            // No need to restore cart here, as we redirect back with input, session should persist
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        // Log point 4: Payment Method Check & Signature Verification
        Log::info('Payment Method Selected:', ['method' => $validatedData['payment_method']]);

        if ($validatedData['payment_method'] === 'razorpay') {
            // Verify that necessary Razorpay fields are present after validation
            if (empty($validatedData['razorpay_payment_id']) || empty($validatedData['razorpay_order_id']) || empty($validatedData['razorpay_signature'])) {
                 Log::error('CRITICAL: Razorpay payment method selected, but required fields are missing after validation.', $validatedData);
                 session()->put('cart', session('cart_backup', [])); // Restore cart session
                 return redirect()->route($this->getCheckoutRouteName())
                        ->with('error', 'Payment details missing. Please try the payment process again.');
            }

            Log::info('Attempting Razorpay Signature Verification...');
            $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
            try {
                $attributes = [
                    'razorpay_order_id' => $validatedData['razorpay_order_id'],
                    'razorpay_payment_id' => $validatedData['razorpay_payment_id'],
                    'razorpay_signature' => $validatedData['razorpay_signature']
                ];
                $api->utility->verifyPaymentSignature($attributes);
                Log::info('Razorpay Signature Verification PASSED.');

            } catch (SignatureVerificationError $e) {
                Log::error('Razorpay Signature Verification FAILED:', ['message' => $e->getMessage(), 'attributes' => $attributes]);
                session()->put('cart', session('cart_backup', [])); // Restore cart session
                return redirect()->route($this->getCheckoutRouteName())
                       ->with('error', 'Payment verification failed. Security check did not pass. Please try again or contact support.');
            } catch (\Exception $e) {
                 Log::error('Razorpay Signature Verification General Error:', ['message' => $e->getMessage()]);
                 session()->put('cart', session('cart_backup', [])); // Restore cart session
                 return redirect()->route($this->getCheckoutRouteName())
                        ->with('error', 'An error occurred during payment verification. Please contact support.');
            }
        }

        // Log point 5: Use the backed-up cart for order creation
        // This ensures we use the cart state from *before* potential modifications during the request lifecycle
        $cartForOrder = session('cart_backup', []);
        if (empty($cartForOrder)) {
            // This is a fallback, should have been caught earlier if session was lost
            Log::error('CRITICAL: Cart backup is empty AFTER validation/verification. This should not happen.');
            return redirect()->route('cart.index')->with('error', 'Your cart session expired unexpectedly. Please try again.');
        }
        Log::info('Using cart from backup for order creation.', ['cart_empty' => empty($cartForOrder)]);


        // Log point 6: Calculate Total from the cart being used for the order
        $cartTotal = collect($cartForOrder)->sum(fn($product) => ($product['price'] ?? 0) * ($product['quantity'] ?? 0));
        Log::info('Calculated Cart Total for Order:', ['total' => $cartTotal]);
        if ($cartTotal <= 0) {
             Log::error('CRITICAL: Cart total is zero or negative before order creation.', ['total' => $cartTotal]);
             session()->put('cart', $cartForOrder); // Restore cart session
             return redirect()->route($this->getCheckoutRouteName())->with('error', 'Cannot place order with zero total.');
        }

        // Log point 7: Check Auth User
        $userId = Auth::id();
        Log::info('Authenticated User ID:', ['user_id' => $userId ?? 'Guest/Not Logged In']);
        // Decide if guest checkout is allowed or enforce login
        if (!$userId && env('ALLOW_GUEST_CHECKOUT', false) == false) { // Example: Check an env variable
             Log::error('User is not authenticated, and guest checkout is disabled.');
             session()->put('cart', $cartForOrder); // Restore cart session
             return redirect()->route('login')->with('error', 'Please log in to complete your order.');
        }


        // Log point 8: Prepare Order Data
        $orderData = [
            'user_id' => $userId, // Can be null if guest checkout is allowed and DB schema permits
            'products' => $cartForOrder, // Pass the raw PHP array; Model casting will handle JSON encoding
            'total_price' => $cartTotal,
            'status' => ($validatedData['payment_method'] === 'razorpay') ? 'paid' : 'pending', // Use 'paid' for successful razorpay
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'street_address' => $validatedData['street_address'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'country' => $validatedData['country'],
            'payment_method' => $validatedData['payment_method'],
            'razorpay_payment_id' => $validatedData['razorpay_payment_id'] ?? null, // Use validated data, null if COD
            'razorpay_order_id' => $validatedData['razorpay_order_id'] ?? null,     // Use validated data, null if COD
            // DO NOT store the signature
        ];
        Log::info('Data Prepared for Order::create (using model casting for products):', $orderData);

        // Log point 9: Attempt Order Creation
        Log::info('Attempting Order::create...');
        try {
            // Ensure your Order model's $fillable array includes ALL keys from $orderData
            $order = Order::create($orderData);
            Log::info('Order::create SUCCEEDED.', ['order_id' => $order->id]);

        } catch (\Exception $e) {
            Log::error('CRITICAL: Order::create FAILED:', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(), // Full trace for detailed debugging
                'order_data_attempted' => $orderData // Log the exact data that failed
                ]);
            // Restore the cart session before redirecting
            session()->put('cart', $cartForOrder);
            return redirect()->route($this->getCheckoutRouteName())
                   ->with('error', 'We encountered a problem saving your order details. Please contact support if this issue persists.');
        }

        // Log point 10: Clear Session data related to the completed cart/order
        Log::info('Order placed successfully. Clearing session data...', ['keys_to_forget' => ['cart', 'cart_total', 'cart_backup', 'razorpay_order_id']]);
        session()->forget(['cart', 'cart_total', 'cart_backup', 'razorpay_order_id']);
        Log::info('Session data cleared.');

        // Log point 11: Redirecting to Order Show page
        Log::info('Redirecting to orders.show route.', ['order_id' => $order->id]);
        // Redirect to the order confirmation/details page
        return redirect()->route('orders.show', $order->id)->with('success', 'Your order has been placed successfully!');
    }


    /**
     * Display the details of a specific order.
     */
    public function showOrder($orderId)
    {
        // Find the order, ensuring it belongs to the logged-in user (if applicable)
        $query = Order::query();
        if (Auth::check()) {
             // Restrict access for logged-in users to their own orders
             $query->where('user_id', Auth::id());
        } else {
             // Handle guest access if needed - perhaps via a unique token stored in session/email?
             // For now, let's assume guests can't view past orders this way easily.
             // If guests placed the order, you might need another way to look it up.
             // Temporarily, let's just find by ID, but add auth checks if needed.
            // return redirect()->route('login')->with('error', 'Please log in to view your orders.');
        }

        $order = $query->findOrFail($orderId); // Find order by ID, respecting user scope if logged in

        // You might need to eager load related data like user or items if displaying them
        // $order->load('user', 'items');

        return view('order_details', compact('order')); // Ensure you have an 'order_details.blade.php' view
    }

    /**
     * Display a list of the current user's orders.
     */
    public function index()
    {
        // Ensure user is authenticated to view their order history
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your order history.');
        }

        $orders = Order::where('user_id', Auth::id())
                       ->latest() // Order by most recent first
                       ->paginate(15); // Use pagination for large lists

        return view('orders.index', compact('orders')); // Ensure you have an 'orders/index.blade.php' view
    }


    /**
     * Helper to get the checkout route name.
     */
    private function getCheckoutRouteName(): string
    {
        return 'checkout';
    }
}