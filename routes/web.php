<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ManageOrderController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/about', [HomeController::class, 'about'])->name('front.about');
Route::get('/shop', [HomeController::class, 'shop'])->name('front.shop');
Route::get('/contact', [HomeController::class, 'contact'])->name('front.contact');
Route::get('/product/{slug}', [App\Http\Controllers\Front\ProductController::class, 'show'])->name('product.detail');
Route::get('/product-search-suggestions', [App\Http\Controllers\Front\ProductController::class, 'autocomplete'])->name('product.autocomplete');
Route::get('/ajax-filter-products', [App\Http\Controllers\Front\ProductController::class, 'ajaxFilter'])->name('ajax.filter.products');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('front.cart');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('checkout.process');
Route::get('/payment/return', [OrderController::class, 'handlePaymentReturn'])->name('payment.return');
Route::post('/payment/callback', [OrderController::class, 'handlePaymentCallback'])->name('payment.callback');
Route::post('/webhook/stripe', [OrderController::class, 'handleWebhook'])->name('webhook.stripe');
Route::get('/payment/success', [OrderController::class, 'handlePaymentSuccess'])->name('payment.success');
Auth::routes();


Auth::routes(['verify' => true]);
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $user = User::find(auth()->user()->id);

    if ($user) {
        $user->email_verified_at = date('now');
        $user->save();

        Auth::logout();
        return redirect()->route('login')->with('success', 'Email Verified Successfully. Please login now.');
    }
})->middleware(['auth', 'signed'])->name('verification.verify');





Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change.password');

// Admin routes with 'admin' prefix
Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [LoginController::class, 'login'])->name('admin.login.submit');
    });

    Route::middleware('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        // category routes
        Route::get('/categories', [CategoryController::class, 'list'])->name('admin.categories.list');
        Route::get('/categories/get', [CategoryController::class, 'get'])->name('admin.categories.get');
        Route::prefix('category')->group(function () {
            Route::get('/add', [CategoryController::class, 'add'])->name('admin.category.add');
            Route::post('/store', [CategoryController::class, 'store'])->name('admin.category.store');
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.category.edit');
            Route::put('/update/{id}', [CategoryController::class, 'update'])->name('admin.category.update');
            Route::post('/status/{id}', [CategoryController::class, 'status'])->name('admin.category.status');
            Route::delete('/delete/{id}', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
        });
        // products routes
        Route::get('/products', [ProductController::class, 'list'])->name('admin.products.list');
        Route::get('/products/get', [ProductController::class, 'get'])->name('admin.products.get');
        Route::prefix('product')->group(function () {
            Route::get('/add', [ProductController::class, 'add'])->name('admin.product.add');
            Route::post('/store', [ProductController::class, 'store'])->name('admin.product.store');
            Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('admin.product.edit');
            Route::put('/update/{id}', [ProductController::class, 'update'])->name('admin.product.update');
            Route::post('/status/{id}', [ProductController::class, 'status'])->name('admin.product.status');
            Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('admin.product.destroy');

        });
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
        Route::get('/profile-settings', [ProfileController::class, 'settings'])->name('admin.profile.settings');
        Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('admin.profile.update');
        // users management
         Route::get('/users', [UserController::class, 'list'])->name('admin.users.list');
        Route::get('/users/get', [UserController::class, 'get'])->name('admin.users.get');
        Route::prefix('user')->group(function () {
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.user.edit');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
            Route::post('/status/{id}', [UserController::class, 'status'])->name('admin.user.status');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
            Route::post('/toggle-suspend', [UserController::class, 'toggleSuspend'])->name('admin.user.toggle_suspend');
        });
        Route::get('/orders', [ManageOrderController::class, 'list'])->name('admin.orders.list');
        Route::get('/orders/get', [ManageOrderController::class, 'get'])->name('admin.orders.get');
        Route::get('/order/details/{id}', [ManageOrderController::class, 'detail'])->name('admin.order.details');
        Route::post('/order/status/{id}', [ManageOrderController::class, 'status'])->name('admin.order.status');
    });
});
