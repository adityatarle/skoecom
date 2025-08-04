<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Get cart items (Guest - Session-based)
     */
    public function index()
    {
        try {
            $cart = session()->get('cart', []);
            $cartData = $this->getCartData($cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Cart retrieved successfully',
                'data' => [
                    'items' => array_values($cart),
                    'count' => $cartData['count'],
                    'subtotal' => $cartData['subtotal'],
                    'subtotal_formatted' => $cartData['subtotal_formatted'],
                    'is_guest' => true
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add item to cart (Guest - Session-based)
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $productId = $request->product_id;
            $quantity = $request->quantity ?? 1;

            $product = Product::with('images')->find($productId);

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found'
                ], 404);
            }

            $cart = session()->get('cart', []);

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image' => $product->images->first()?->image_path ?? 'images/no-image.png',
                    'quantity' => $quantity
                ];
            }

            session()->put('cart', $cart);
            $cartData = $this->getCartData($cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully',
                'data' => [
                    'item' => $cart[$productId],
                    'cart_count' => $cartData['count'],
                    'cart_total' => $cartData['subtotal'],
                    'cart_total_formatted' => $cartData['subtotal_formatted']
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add product to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update cart item quantity (Guest - Session-based)
     */
    public function update(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $cart = session()->get('cart', []);

            if (!isset($cart[$productId])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found in cart'
                ], 404);
            }

            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            $cartData = $this->getCartData($cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully',
                'data' => [
                    'item' => $cart[$productId],
                    'cart_count' => $cartData['count'],
                    'cart_total' => $cartData['subtotal'],
                    'cart_total_formatted' => $cartData['subtotal_formatted']
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from cart (Guest - Session-based)
     */
    public function remove($productId)
    {
        try {
            $cart = session()->get('cart', []);

            if (!isset($cart[$productId])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found in cart'
                ], 404);
            }

            unset($cart[$productId]);
            session()->put('cart', $cart);

            $cartData = $this->getCartData($cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from cart successfully',
                'data' => [
                    'cart_count' => $cartData['count'],
                    'cart_total' => $cartData['subtotal'],
                    'cart_total_formatted' => $cartData['subtotal_formatted']
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove product from cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear cart (Guest - Session-based)
     */
    public function clear()
    {
        try {
            session()->forget('cart');

            return response()->json([
                'status' => 'success',
                'message' => 'Cart cleared successfully',
                'data' => [
                    'cart_count' => 0,
                    'cart_total' => 0,
                    'cart_total_formatted' => '₹0.00'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clear cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cart count (Guest - Session-based)
     */
    public function count()
    {
        try {
            $cart = session()->get('cart', []);
            $count = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'status' => 'success',
                'data' => [
                    'count' => $count
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to get cart count',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user cart items (Authenticated - Database-based)
     */
    public function userCart(Request $request)
    {
        try {
            $user = $request->user();
            $cart = session()->get('cart', []);

            // If user has session cart, merge it with database cart
            if (!empty($cart)) {
                $this->mergeSessionCartWithDatabase($user, $cart);
                session()->forget('cart');
            }

            $wishlist = Wishlist::where('user_id', $user->id)
                ->with(['product.images'])
                ->get()
                ->map(function ($item) {
                    return [
                        'product_id' => $item->product->id,
                        'name' => $item->product->name,
                        'price' => $item->product->price,
                        'image' => $item->product->images->first()?->image_path ?? 'images/no-image.png',
                        'quantity' => 1,
                        'in_wishlist' => true
                    ];
                });

            return response()->json([
                'status' => 'success',
                'message' => 'User cart retrieved successfully',
                'data' => [
                    'items' => $wishlist,
                    'count' => $wishlist->count(),
                    'subtotal' => $wishlist->sum(function ($item) {
                        return $item['price'] * $item['quantity'];
                    }),
                    'is_guest' => false
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve user cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add item to user cart (Authenticated - Database-based)
     */
    public function userAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();
            $productId = $request->product_id;

            // Check if already in wishlist
            $existing = Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if ($existing) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product already in cart'
                ], 400);
            }

            // Add to wishlist (used as cart for authenticated users)
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);

            $count = Wishlist::where('user_id', $user->id)->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully',
                'data' => [
                    'cart_count' => $count
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to add product to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user cart item (Authenticated - Database-based)
     */
    public function userUpdate(Request $request, $productId)
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1|max:100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $request->user();

            // For authenticated users, we use wishlist as cart
            // Quantity is managed differently - this is a placeholder for future implementation
            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from user cart (Authenticated - Database-based)
     */
    public function userRemove($productId)
    {
        try {
            $user = request()->user();

            Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->delete();

            $count = Wishlist::where('user_id', $user->id)->count();

            return response()->json([
                'status' => 'success',
                'message' => 'Product removed from cart successfully',
                'data' => [
                    'cart_count' => $count
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to remove product from cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear user cart (Authenticated - Database-based)
     */
    public function userClear()
    {
        try {
            $user = request()->user();

            Wishlist::where('user_id', $user->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Cart cleared successfully',
                'data' => [
                    'cart_count' => 0
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to clear cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper method to get cart data
     */
    private function getCartData($cart)
    {
        $count = array_sum(array_column($cart, 'quantity'));
        $subtotal = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return [
            'count' => $count,
            'subtotal' => $subtotal,
            'subtotal_formatted' => '₹' . number_format($subtotal, 2)
        ];
    }

    /**
     * Helper method to merge session cart with database cart
     */
    private function mergeSessionCartWithDatabase($user, $cart)
    {
        foreach ($cart as $productId => $item) {
            $existing = Wishlist::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->first();

            if (!$existing) {
                Wishlist::create([
                    'user_id' => $user->id,
                    'product_id' => $productId
                ]);
            }
        }
    }
}