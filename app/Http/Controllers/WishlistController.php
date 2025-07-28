<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        if (Auth::check()) {
            $existingWishlistItem = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if (!$existingWishlistItem) {
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                ]);
            }

            return back()->with('success', 'Product added to your wishlist!');
        } else {
            $wishlist = session()->get('wishlist', []);

            if (!isset($wishlist[$productId])) {
                $wishlist[$productId] = [
                    "name" => $product->name,
                    "price" => $product->price,
                    "image" => $product->images->first()->image_path ?? 'images/no-image.png',
                ];
                session()->put('wishlist', $wishlist);
            }

            return back()->with('success', 'Product added to your wishlist!');
        }
    }

    public function getWishlistCount()
    {
        return response()->json([
            'wishlist_count' => Auth::check()
                ? Wishlist::where('user_id', Auth::id())->count()
                : (session('wishlist') ? count(session('wishlist')) : 0)
        ]);
    }


    public function remove(Request $request, $productId)
    {
        if (Auth::check()) {
            Wishlist::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->delete();

            return back()->with('success', 'Product removed from your wishlist!');
        } else {
            $wishlist = session()->get('wishlist', []);
            if (isset($wishlist[$productId])) {
                unset($wishlist[$productId]);
                session()->put('wishlist', $wishlist);
            }
            return back()->with('success', 'Product removed from your wishlist!');
        }
    }
    public function index()
    {
        if (Auth::check()) {
            $wishlistItems = Wishlist::where('user_id', Auth::id())->with('product')->get();
        } else {
            $wishlistItems = session()->get('wishlist', []);
        }
        return view('cart.wishlist', compact('wishlistItems'));
    }

    public function addToWishlist(Request $request)
    {
        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found!']);
        }

        if (Auth::check()) {
            // Logged-in user: Add to database, not session
            $existingWishlistItem = Wishlist::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if (!$existingWishlistItem) {
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                ]);
            } else {
                return response()->json(['status' => 'info', 'message' => 'Already in wishlist!']);
            }

            $wishlistCount = Wishlist::where('user_id', Auth::id())->count();
        } else {
            // Guest user: Store in session
            $wishlist = session()->get('wishlist', []);

            if (!isset($wishlist[$product->id])) {
                $wishlist[$product->id] = [
                    "name" => $product->name,
                    "price" => $product->price,
                    "image" => $product->images->first()->image_path ?? 'images/no-image.png'
                ];
                session()->put('wishlist', $wishlist);
            } else {
                return response()->json(['status' => 'info', 'message' => 'Already in wishlist!']);
            }

            $wishlistCount = count(session('wishlist', []));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to wishlist!',
            'wishlist_count' => $wishlistCount,
        ]);
    }
}
