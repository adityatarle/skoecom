<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Add product to cart with improved validation and error handling
     */
    public function addToCart(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer|exists:products,id',
                'quantity' => 'nullable|integer|min:1|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid product or quantity specified.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $productId = $request->product_id;
            $quantity = $request->quantity ?? 1;

            // Find the product with eager loading
            $product = Product::with('images')->find($productId);

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found!'
                ], 404);
            }

            // Get current cart
            $cart = session()->get('cart', []);

            // Add or update product in cart
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

            // Save cart to session
            session()->put('cart', $cart);

            // Calculate totals
            $cartData = $this->getCartData($cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!',
                'cart_count' => $cartData['count'],
                'cart_total' => $cartData['total'],
                'cart_total_formatted' => $cartData['total_formatted'],
                'item' => $cart[$productId]
            ]);

        } catch (\Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage(), [
                'product_id' => $request->product_id ?? null,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while adding the product to cart.'
            ], 500);
        }
    }

    /**
     * Display cart page
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Update product quantity in cart
     */
    public function updateQuantity(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer',
                'action' => 'required|in:increase,decrease',
                'quantity' => 'nullable|integer|min:1|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request parameters.'
                ], 422);
            }

            $productId = $request->product_id;
            $action = $request->action;
            $cart = session()->get('cart', []);

            if (!isset($cart[$productId])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart.'
                ], 404);
            }

            // Update quantity based on action
            if ($action === 'increase') {
                $cart[$productId]['quantity']++;
            } elseif ($action === 'decrease') {
                if ($cart[$productId]['quantity'] > 1) {
                    $cart[$productId]['quantity']--;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Quantity cannot be less than 1. Use remove instead.'
                    ], 400);
                }
            }

            // Save updated cart
            session()->put('cart', $cart);

            // Calculate new totals
            $cartData = $this->getCartData($cart);
            $item = $cart[$productId];
            $subtotal = $item['quantity'] * $item['price'];

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'itemId' => $productId,
                'newQuantity' => $item['quantity'],
                'newSubtotal' => $subtotal,
                'newSubtotalFormatted' => '₹' . number_format($subtotal, 2),
                'cartTotal' => $cartData['total'],
                'cartTotalFormatted' => $cartData['total_formatted'],
                'cartCount' => $cartData['count']
            ]);

        } catch (\Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the cart.'
            ], 500);
        }
    }

    /**
     * Increase product quantity
     */
    public function increaseQuantity(Request $request, $id)
    {
        $request->merge(['product_id' => $id, 'action' => 'increase']);
        
        if ($request->ajax() || $request->wantsJson()) {
            return $this->updateQuantity($request);
        }
        
        // Fallback for non-AJAX requests
        $response = $this->updateQuantity($request);
        $data = $response->getData(true);
        
        if ($data['success']) {
            return redirect()->route('cart.index')->with('success', $data['message']);
        } else {
            return redirect()->route('cart.index')->with('error', $data['message']);
        }
    }

    /**
     * Decrease product quantity
     */
    public function decreaseQuantity(Request $request, $id)
    {
        $request->merge(['product_id' => $id, 'action' => 'decrease']);
        
        if ($request->ajax() || $request->wantsJson()) {
            return $this->updateQuantity($request);
        }
        
        // Fallback for non-AJAX requests
        $response = $this->updateQuantity($request);
        $data = $response->getData(true);
        
        if ($data['success']) {
            return redirect()->route('cart.index')->with('success', $data['message']);
        } else {
            return redirect()->route('cart.index')->with('error', $data['message']);
        }
    }

    /**
     * Remove product from cart
     */
    public function removeFromCart(Request $request, $id)
    {
        try {
            $cart = session()->get('cart', []);

            if (!isset($cart[$id])) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Product not found in cart.'
                    ], 404);
                }
                return redirect()->route('cart.index')->with('error', 'Product not found in cart.');
            }

            // Remove item from cart
            unset($cart[$id]);
            session()->put('cart', $cart);

            // Calculate new totals
            $cartData = $this->getCartData($cart);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart successfully!',
                    'itemId' => $id,
                    'cartTotal' => $cartData['total'],
                    'cartTotalFormatted' => $cartData['total_formatted'],
                    'cartIsEmpty' => $cartData['count'] === 0,
                    'cartCount' => $cartData['count']
                ]);
            }

            return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully!');

        } catch (\Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while removing the product.'
                ], 500);
            }
            
            return redirect()->route('cart.index')->with('error', 'An error occurred while removing the product.');
        }
    }

    /**
     * Get cart count and totals for AJAX requests
     */
    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $cartData = $this->getCartData($cart);
        
        return response()->json([
            'cart_count' => $cartData['count'],
            'cart_total' => $cartData['total'],
            'cart_total_formatted' => $cartData['total_formatted']
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clearCart(Request $request)
    {
        session()->forget('cart');
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully!',
                'cartCount' => 0,
                'cartTotal' => 0,
                'cartTotalFormatted' => '₹0.00'
            ]);
        }
        
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }

    /**
     * Calculate cart data (count, total, formatted total)
     */
    private function getCartData($cart)
    {
        $count = count($cart);
        $total = 0;

        if (is_array($cart)) {
            foreach ($cart as $details) {
                if (isset($details['quantity'], $details['price']) && 
                    is_numeric($details['quantity']) && is_numeric($details['price'])) {
                    $total += $details['quantity'] * $details['price'];
                }
            }
        }

        return [
            'count' => $count,
            'total' => $total,
            'total_formatted' => '₹' . number_format($total, 2)
        ];
    }
}