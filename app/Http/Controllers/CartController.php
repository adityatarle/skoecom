<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session; // Make sure Session Facade is imported

class CartController extends Controller
{
    // --- Add To Cart (Already returns JSON, looks good) ---
    public function addToCart(Request $request)
    {
        // Consider adding validation for product_id
        $product = Product::find($request->product_id);

        if (!$product) {
            // Return 404 if product not found
            return response()->json(['status' => 'error', 'message' => 'Product not found!'], 404);
        }

        $cart = session()->get('cart', []);
        $productId = $product->id; // Use a variable for clarity

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "name" => $product->name,
                "price" => $product->price,
                // Use nullish coalescing for potentially missing image
                "image" => $product->images->first()?->image_path ?? 'images/no-image.png',
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        // Calculate total for potential header update
        $total = $this->calculateCartTotal($cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Added to cart!',
            'cart_count' => count($cart), // Number of unique items
            'cart_total' => $total,
            'cart_total_formatted' => '₹' . number_format($total, 2),
            // Optionally include item details if needed by JS
            // 'item' => $cart[$productId]
        ]);
    }

    // --- Display Cart (No change needed) ---
    public function cart()
    {
        $cart = session()->get('cart', []); // Get the cart data from the session
        return view('cart.index', compact('cart')); // Pass the cart data to the view
    }

    // --- Increase Quantity (Modified for AJAX) ---
    public function increaseQuantity(Request $request, $id) // Inject Request
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);

            // Check if request is AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return $this->getCartUpdateResponse($id, $cart, 'Quantity increased!'); // Return JSON
            }

            // Fallback for non-AJAX
            session()->flash('success', 'Quantity increased!');
            return redirect()->route('cart.index');

        } else {
            // Handle case where product is not in cart
             if ($request->ajax() || $request->wantsJson()) {
                 return response()->json(['success' => false, 'message' => 'Product not found in cart.'], 404); // JSON Error
             }
            session()->flash('error', 'Product not found in cart.');
            return redirect()->route('cart.index');
        }
    }

    // --- Decrease Quantity (Modified for AJAX) ---
    public function decreaseQuantity(Request $request, $id) // Inject Request
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) { // Prevent quantity from going below 1
                $cart[$id]['quantity']--;
                session()->put('cart', $cart);

                if ($request->ajax() || $request->wantsJson()) {
                     return $this->getCartUpdateResponse($id, $cart, 'Quantity decreased!'); // Return JSON
                }

                // Fallback for non-AJAX
                session()->flash('success', 'Quantity decreased!');
                return redirect()->route('cart.index');

            } else {
                // Quantity is 1, cannot decrease further
                 if ($request->ajax() || $request->wantsJson()) {
                    // Send error for AJAX request
                    return response()->json(['success' => false, 'message' => 'Quantity cannot be less than 1.'], 400); // 400 Bad Request
                 }
                 // Fallback for non-AJAX
                session()->flash('warning', 'Quantity cannot be less than 1. Remove the item if needed.');
                return redirect()->route('cart.index');
            }
        } else {
            // Handle case where product is not in cart
            if ($request->ajax() || $request->wantsJson()) {
                 return response()->json(['success' => false, 'message' => 'Product not found in cart.'], 404); // JSON Error
             }
            session()->flash('error', 'Product not found in cart.');
            return redirect()->route('cart.index');
        }
    }

    // --- Remove From Cart (Modified for AJAX) ---
    public function removeFromCart(Request $request, $id) // Inject Request
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart); // Update the cart in session

             if ($request->ajax() || $request->wantsJson()) {
                 return $this->getCartRemoveResponse($id, $cart, 'Product removed from cart.'); // Return JSON
             }

            // Fallback for non-AJAX
            session()->flash('success', 'Product removed from cart!');
            return redirect()->route('cart.index');

        } else {
             // Handle case where product is not in cart
            if ($request->ajax() || $request->wantsJson()) {
                 return response()->json(['success' => false, 'message' => 'Product not found in cart.'], 404); // JSON Error
             }
            session()->flash('error', 'Product not found in cart.');
            return redirect()->route('cart.index');
        }
    }


    // --- HELPER METHODS FOR JSON RESPONSE & Calculations ---

    private function calculateCartTotal($cart) {
        $total = 0;
        if (is_array($cart)) { // Ensure $cart is an array
             foreach ($cart as $details) {
                // Ensure quantity and price are numeric before calculation
                if (isset($details['quantity'], $details['price']) && is_numeric($details['quantity']) && is_numeric($details['price'])) {
                    $total += $details['quantity'] * $details['price'];
                }
            }
        }
        return $total;
    }

    // Get cart count for AJAX requests
    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = count($cart);
        $total = $this->calculateCartTotal($cart);
        
        return response()->json([
            'cart_count' => $count,
            'cart_total' => $total,
            'cart_total_formatted' => '₹' . number_format($total, 2)
        ]);
    }

    // Response for quantity increase/decrease AJAX
    private function getCartUpdateResponse($id, $cart, $message = 'Cart updated!') {
         $total = $this->calculateCartTotal($cart);
         $item = $cart[$id] ?? null; // Get item or null if somehow missing after update

        if (!$item) {
            // This shouldn't normally happen if called after successful update
            return response()->json(['success' => false, 'message' => 'Error retrieving updated item details.'], 500);
        }

         $subtotal = $item['quantity'] * $item['price'];

         return response()->json([
             'success'           => true,
             'message'           => $message,
             'itemId'            => $id,
             'newQuantity'       => $item['quantity'],
             'newSubtotal'       => $subtotal,
             'newSubtotalFormatted' => '₹' . number_format($subtotal, 2),
             'cartTotal'         => $total,
             'cartTotalFormatted'=> '₹' . number_format($total, 2),
             'cartCount'         => count($cart)
         ]);
    }

     // Response for item removal AJAX
    private function getCartRemoveResponse($id, $cart, $message = 'Item removed.') {
         $total = $this->calculateCartTotal($cart);
         $cartCount = count($cart);

        return response()->json([
            'success'            => true,
            'message'            => $message,
            'itemId'             => $id, // ID of the removed item
            'cartTotal'          => $total,
            'cartTotalFormatted' => '₹' . number_format($total, 2),
            'cartIsEmpty'        => $cartCount === 0,
            'cartCount'          => $cartCount
        ]);
    }
}