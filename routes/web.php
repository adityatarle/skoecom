<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MainpageController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\RazorpayController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\AdminController;

// Public Routes
Route::get('/', [MainpageController::class, 'index'])->name('main.page');
Route::get('/home', [MainpageController::class, 'index'])->name('home');
Route::get('/products', [MainpageController::class, 'products'])->name('products');
Route::get('/contact', [MainpageController::class, 'contactform'])->name('contact');
Route::post('/contact', [MainpageController::class, 'contactstore'])->name('contact.store');
Route::get('/product/{product}', [MainpageController::class, 'productDetails'])->name('product.details');
Route::post('/product/inquiry', [ProductController::class, 'storeInquiry'])->name('product.inquiry');
Route::get('/product/{product}/review/create', [MainpageController::class, 'createReviewForm'])->name('product.review.create');
Route::post('/product/review', [MainpageController::class, 'submitReview'])->name('product.review');
Route::get('/filter-products', [MainpageController::class, 'filterProducts'])->name('filter.products');

// Cart Routes (Work for both guest and authenticated users)
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::patch('/cart/increase/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
Route::patch('/cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

// Wishlist Routes (Work for both guest and authenticated users)
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist/count', [WishlistController::class, 'getWishlistCount'])->name('wishlist.count');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Checkout Routes (Guest checkout allowed with restrictions)
Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');

// Payment Routes
Route::get('/razorpay-create-order', [RazorpayController::class, 'createOrder'])->name('razorpay.createOrder');
Route::post('/payment-success', [RazorpayController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/test-razorpay', [RazorpayController::class, 'testConfig'])->name('razorpay.test');

// Order Routes (Requires authentication for viewing orders)
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [CheckoutController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [CheckoutController::class, 'showOrder'])->name('orders.show');
    Route::post('/orders/{order}/reorder', [CheckoutController::class, 'reorder'])->name('orders.reorder');
    
    // Customer Profile Routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin Routes (Protected by Auth and Admin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dash', [HomeController::class, 'index'])->name('dashboard');

    // Product Inquiries
    Route::get('/products/inquiries', [ProductController::class, 'showInquiries'])->name('admin.product.inquiries');
    Route::delete('/products/inquiries/{productInquiry}', [ProductController::class, 'destroyInquiry'])->name('admin.product.inquiry.destroy');

    // Product Management
    Route::prefix('product')->name('admin.product.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Category Management
    Route::prefix('category')->name('admin.category.')->group(function () {
        Route::get('/', [ProductCategoryController::class, 'index'])->name('index');
        Route::get('/create', [ProductCategoryController::class, 'create'])->name('create');
        Route::post('/', [ProductCategoryController::class, 'store'])->name('store');
        Route::get('/{category}/edit', [ProductCategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [ProductCategoryController::class, 'update'])->name('update');
        Route::delete('/{category}', [ProductCategoryController::class, 'destroy'])->name('destroy');
    });
    
    Route::resource('subcategory', SubcategoryController::class)->names('admin.subcategory');

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');

    // Orders Management
    Route::get('/orders', [OrdersController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrdersController::class, 'show'])->name('admin.orders.show');
    Route::delete('/orders/{id}', [OrdersController::class, 'destroy'])->name('admin.orders.destroy');
    Route::post('/orders/{id}/status', [OrdersController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/orders/export', [OrdersController::class, 'export'])->name('admin.orders.export');
});

// Admin subcategories helper route
Route::get('/admin/subcategories/get-by-category', [SubcategoryController::class, 'getByCategory'])->name('admin.subcategory.getByCategory');
