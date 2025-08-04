<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\SearchController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Routes
Route::prefix('v1')->group(function () {
    
    // Authentication Routes
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    
    // Public Product Routes
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    Route::get('/products/featured', [ProductController::class, 'featured']);
    Route::get('/products/on-sale', [ProductController::class, 'onSale']);
    Route::get('/products/search', [ProductController::class, 'search']);
    
    // Category Routes
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::get('/categories/{category}/products', [CategoryController::class, 'products']);
    Route::get('/subcategories', [CategoryController::class, 'subcategories']);
    Route::get('/subcategories/{subcategory}', [CategoryController::class, 'subcategoryShow']);
    
    // Banner Routes
    Route::get('/banners', [BannerController::class, 'index']);
    Route::get('/banners/active', [BannerController::class, 'active']);
    
    // Blog Routes
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/{blog}', [BlogController::class, 'show']);
    
    // Search Routes
    Route::get('/search', [SearchController::class, 'search']);
    
    // Guest Cart Routes (Session-based)
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index']);
        Route::post('/add', [CartController::class, 'add']);
        Route::put('/update/{productId}', [CartController::class, 'update']);
        Route::delete('/remove/{productId}', [CartController::class, 'remove']);
        Route::delete('/clear', [CartController::class, 'clear']);
        Route::get('/count', [CartController::class, 'count']);
    });
    
    // Guest Wishlist Routes (Session-based)
    Route::prefix('wishlist')->group(function () {
        Route::get('/', [WishlistController::class, 'index']);
        Route::post('/add', [WishlistController::class, 'add']);
        Route::delete('/remove/{productId}', [WishlistController::class, 'remove']);
        Route::get('/count', [WishlistController::class, 'count']);
    });
    
    // Protected Routes (Require Authentication)
    Route::middleware('auth:sanctum')->group(function () {
        
        // User Profile Routes
        Route::prefix('profile')->group(function () {
            Route::get('/', [ProfileController::class, 'show']);
            Route::put('/', [ProfileController::class, 'update']);
            Route::put('/password', [ProfileController::class, 'updatePassword']);
            Route::delete('/', [ProfileController::class, 'destroy']);
        });
        
        // Authenticated Cart Routes (Database-based)
        Route::prefix('user/cart')->group(function () {
            Route::get('/', [CartController::class, 'userCart']);
            Route::post('/add', [CartController::class, 'userAdd']);
            Route::put('/update/{productId}', [CartController::class, 'userUpdate']);
            Route::delete('/remove/{productId}', [CartController::class, 'userRemove']);
            Route::delete('/clear', [CartController::class, 'userClear']);
        });
        
        // Authenticated Wishlist Routes (Database-based)
        Route::prefix('user/wishlist')->group(function () {
            Route::get('/', [WishlistController::class, 'userWishlist']);
            Route::post('/add', [WishlistController::class, 'userAdd']);
            Route::delete('/remove/{productId}', [WishlistController::class, 'userRemove']);
        });
        
        // Order Routes
        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('/{order}', [OrderController::class, 'show']);
            Route::post('/{order}/reorder', [OrderController::class, 'reorder']);
            Route::post('/{order}/cancel', [OrderController::class, 'cancel']);
        });
        
        // Checkout Routes
        Route::prefix('checkout')->group(function () {
            Route::get('/', [CheckoutController::class, 'index']);
            Route::post('/place-order', [CheckoutController::class, 'placeOrder']);
            Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon']);
            Route::post('/validate-address', [CheckoutController::class, 'validateAddress']);
        });
        
        // Review Routes
        Route::prefix('reviews')->group(function () {
            Route::get('/product/{product}', [ReviewController::class, 'productReviews']);
            Route::post('/product/{product}', [ReviewController::class, 'store']);
            Route::put('/{review}', [ReviewController::class, 'update']);
            Route::delete('/{review}', [ReviewController::class, 'destroy']);
        });
        
        // Logout
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    
    // Payment Routes
    Route::prefix('payment')->group(function () {
        Route::post('/razorpay/create-order', [CheckoutController::class, 'createRazorpayOrder']);
        Route::post('/razorpay/verify', [CheckoutController::class, 'verifyRazorpayPayment']);
    });
});

// Health Check Route
Route::get('/health', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is running',
        'timestamp' => now()->toISOString()
    ]);
});