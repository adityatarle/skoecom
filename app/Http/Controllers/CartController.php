<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found!']);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "price" => $product->price,
                "image" => $product->images->first()->image_path ?? 'images/no-image.png',
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return response()->json(['status' => 'success', 'message' => 'Added to cart!', 'cart_count' => count($cart)]);
    }
    public function cart()
    {
        $cart = session()->get('cart', []); // Get the cart data from the session
        return view('cart.index', compact('cart')); // Pass the cart data to the view
    }

    public function increaseQuantity($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
            session()->put('cart', $cart);
            session()->flash('success', 'Quantity increased!');
        } else {
            session()->flash('error', 'Product not found in cart.'); // Handle case where product is not in cart
        }
        return redirect()->route('cart.index');
    }

    public function decreaseQuantity($id)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$id])) {
            if ($cart[$id]['quantity'] > 1) { //Prevent quantity from going below 1
                $cart[$id]['quantity']--;
                session()->put('cart', $cart);
                session()->flash('success', 'Quantity decreased!');
            } else {
                session()->flash('warning', 'Quantity cannot be less than 1. Remove the item if you want to delete it.');
            }
        } else {
            session()->flash('error', 'Product not found in cart.'); // Handle case where product is not in cart
        }
        return redirect()->route('cart.index');
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart); // Update the cart in session
            session()->flash('success', 'Product removed from cart!');
        } else {
            session()->flash('error', 'Product not found in cart.');
        }

        return redirect()->route('cart.index');
    }
}
