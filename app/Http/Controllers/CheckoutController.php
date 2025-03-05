<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);
        $cartTotal = session('cart_total', 0);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout', compact('cart', 'cartTotal'));
    }

    public function placeOrder(Request $request)
    {
        // Store cart data before validation
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Debugging: Check if cart is stored before validation
        session()->put('cart_backup', $cart);
        // dd('Before Validation:', session('cart_backup'));

        // Validate request
        try {
            $validatedData = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required',
                'street_address' => 'required|string',
                'city' => 'required|string',
                'state' => 'required|string',
                'country' => 'required|string',
                'payment_method' => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd('Validation Failed:', $e->errors());
        }

        // Restore cart data after validation
        $cart = session('cart_backup', []);

        // Debugging: Check if cart is restored
        // dd('After Validation:', $cart);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartTotal = collect($cart)->sum(fn($product) => $product['price'] * $product['quantity']);

        // Create order
        $order = Order::create([
            'user_id' => Auth::id(),
            'products' => json_encode($cart),
            'total_price' => $cartTotal,
            'status' => 'pending',
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'street_address' => $validatedData['street_address'],
            'city' => $validatedData['city'],
            'state' => $validatedData['state'],
            'country' => $validatedData['country'],
            'payment_method' => $validatedData['payment_method'],
        ]);

        // Clear the cart after order placement
        session()->forget(['cart', 'cart_total', 'cart_backup']);

        return redirect()->route('orders.show', $order->id)->with('success', 'Order placed successfully!');
    }



    public function showOrder($orderId)
    {
        $order = Order::findOrFail($orderId);

        return view('order_details', compact('order'));
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

}
