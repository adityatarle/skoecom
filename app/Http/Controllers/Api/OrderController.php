<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Get user orders
     */
    public function index(Request $request)
    {
        try {
            $user = $request->user();
            $perPage = $request->per_page ?? 10;

            $orders = Order::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            $orders->getCollection()->transform(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                    'total_price' => $order->total_price,
                    'total_price_formatted' => '₹' . number_format($order->total_price, 2),
                    'status' => $order->status,
                    'payment_method' => $order->payment_method,
                    'products_count' => count($order->products),
                    'created_at' => $order->created_at,
                    'updated_at' => $order->updated_at
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Orders retrieved successfully',
                'data' => [
                    'orders' => $orders->items(),
                    'pagination' => [
                        'current_page' => $orders->currentPage(),
                        'last_page' => $orders->lastPage(),
                        'per_page' => $orders->perPage(),
                        'total' => $orders->total()
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific order details
     */
    public function show(Order $order, Request $request)
    {
        try {
            $user = $request->user();

            // Check if order belongs to user
            if ($order->user_id !== $user->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }

            $data = [
                'id' => $order->id,
                'order_number' => 'ORD-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
                'total_price' => $order->total_price,
                'total_price_formatted' => '₹' . number_format($order->total_price, 2),
                'status' => $order->status,
                'payment_method' => $order->payment_method,
                'razorpay_payment_id' => $order->razorpay_payment_id,
                'razorpay_order_id' => $order->razorpay_order_id,
                'billing_details' => [
                    'first_name' => $order->first_name,
                    'last_name' => $order->last_name,
                    'email' => $order->email,
                    'phone' => $order->phone,
                    'street_address' => $order->street_address,
                    'city' => $order->city,
                    'state' => $order->state,
                    'country' => $order->country
                ],
                'products' => $order->products,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at
            ];

            return response()->json([
                'status' => 'success',
                'message' => 'Order details retrieved successfully',
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve order details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reorder - Add all products from an order to cart
     */
    public function reorder(Order $order, Request $request)
    {
        try {
            $user = $request->user();

            // Check if order belongs to user
            if ($order->user_id !== $user->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }

            $cart = session()->get('cart', []);
            $addedCount = 0;

            foreach ($order->products as $product) {
                $productId = $product['product_id'] ?? $product['id'];
                $quantity = $product['quantity'] ?? 1;

                if (isset($cart[$productId])) {
                    $cart[$productId]['quantity'] += $quantity;
                } else {
                    $productModel = Product::find($productId);
                    if ($productModel) {
                        $cart[$productId] = [
                            'product_id' => $productModel->id,
                            'name' => $productModel->name,
                            'price' => $productModel->price,
                            'image' => $productModel->images->first()?->image_path ?? 'images/no-image.png',
                            'quantity' => $quantity
                        ];
                        $addedCount++;
                    }
                }
            }

            session()->put('cart', $cart);

            return response()->json([
                'status' => 'success',
                'message' => "Added {$addedCount} products to cart",
                'data' => [
                    'added_count' => $addedCount,
                    'cart_count' => array_sum(array_column($cart, 'quantity'))
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to reorder',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Cancel order
     */
    public function cancel(Order $order, Request $request)
    {
        try {
            $user = $request->user();

            // Check if order belongs to user
            if ($order->user_id !== $user->id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found'
                ], 404);
            }

            // Check if order can be cancelled
            if (!in_array($order->status, ['pending', 'processing'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order cannot be cancelled at this stage'
                ], 400);
            }

            $order->update(['status' => 'cancelled']);

            return response()->json([
                'status' => 'success',
                'message' => 'Order cancelled successfully',
                'data' => [
                    'order_id' => $order->id,
                    'status' => $order->status
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}