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

use App\Http\Controllers\AdminController; //Import if you use admin index page


// Public Routes
Route::get('/home', [MainpageController::class, 'index'])->name('home');
Route::get('/products', [MainpageController::class, 'products'])->name('products');
Route::get('/product/{product}', [MainpageController::class, 'productDetails'])->name('product.details');
Route::get('/', [MainpageController::class, 'index'])->name('main.page');
Route::post('/product/inquiry', [ProductController::class, 'storeInquiry'])->name('product.inquiry');
Route::get('/product/{product}/review/create', [MainpageController::class, 'createReviewForm'])->name('product.review.create');
Route::post('/product/review', [MainpageController::class, 'submitReview'])->name('product.review');

Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])->name('wishlist.add');
Route::delete('/wishlist/remove/{productId}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::get('/wishlist/count', [WishlistController::class, 'getWishlistCount']);

Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');



Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');

Route::get('/cart', [CartController::class, 'cart'])->name('cart.index');
// Route::get('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');

// These would be what your buttons would link

// Route::get('/wishlist/add/{id}',[WishListController::class, 'addToWishlist'])->name('wishlist');
// Route::get('/compare/add/{id}', [CompareController::class, 'addToCompare'])->name('compare');


// Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
// Route::post('checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.process');
// Route::get('/orders/{order}', [CheckoutController::class, 'showOrder'])->name('orders.show');
// Route::post('/checkout/placeOrder', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');

// Add these new routes for quantity adjustments:
    Route::get('/cart/increase/{id}', [CartController::class, 'increaseQuantity'])->name('cart.increase');
    Route::get('/cart/decrease/{id}', [CartController::class, 'decreaseQuantity'])->name('cart.decrease');

// Authentication Routes (These are built-in to Laravel auth)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Logout Route (Outside any specific group)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');

// Customer Profile Routes (Protected by Auth Middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show'); // Profile Display Route
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'placeOrder'])->name('checkout.process');
    Route::get('/orders/{order}', [CheckoutController::class, 'showOrder'])->name('orders.show');
    Route::get('/orders', [CheckoutController::class, 'index'])->name('orders.index');


    // Route::get('/orders/{order}', function (string $id) {
    //     return view('order.show', ['id' => $id]);
    // })->name('orders.show');
     Route::get('/home', [MainpageController::class, 'index'])->name('home');  //Move this here
});


// Admin Routes (Protected by Auth and Admin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dash', [HomeController::class, 'index'])->name('dashboard'); // Added controller to route
    // Route::get('/', [AdminController::class, 'index'])->name('admin.index'); // Admin Dashboard Route

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


    // reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('admin.reviews.index');
    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('admin.reviews.edit');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('admin.reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('admin.reviews.destroy');



});

Route::get('/admin/subcategories/get-by-category', [SubcategoryController::class, 'getByCategory'])->name('admin.subcategory.getByCategory');
