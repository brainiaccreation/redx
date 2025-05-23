<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\GiftCardCodeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ManageOrderController;
use App\Http\Controllers\Admin\WalletTopupController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\WalletController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

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

Route::get('get-products/moogold', function () {
    // API endpoint
    $url = "https://moogold.com/wp-json/v1/api/product/list_product";

    // Replace with the actual category ID (example: Steam = 993)
    $categoryId = 993;

    // Prepare payload
    $data = [
        "category_id" => $categoryId
    ];

    // Encode to JSON
    $payload = json_encode($data);

    // Basic Auth header
    $authHeader = "Basic c3VmaXlhbjpzdWZpeWFuMTIz"; // 'sufiyan:sufiyan123' base64-encoded

    // Initialize cURL
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: $authHeader",
        "Content-Type: application/json"
    ]);

    // Execute request
    $response = curl_exec($ch);

    // Check for errors
    if (curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch);
    } else {
        echo "Response from MooGold:\n";
        echo $response;
    }

    // Close cURL
    curl_close($ch);
});
Route::get('/artisan/{command}', function ($command) {
    $allowedCommands = [
        'storage-link' => 'storage:link',
        'cache-clear' => 'cache:clear',
        'config-clear' => 'config:clear',
        'config-cache' => 'config:cache',
        'route-clear' => 'route:clear',
        'route-cache' => 'route:cache',
        'view-clear' => 'view:clear',
        'permission-cache-reset' => 'permission:cache-reset',
        'optimize' => 'optimize',
        'migrate' => 'migrate',
        'migrate-refresh' => 'migrate:refresh',
        'migrate-rollback' => 'migrate:rollback',
        'db-seed' => 'db:seed',
        'queue-work' => 'queue:work',
        'queue-restart' => 'queue:restart',
    ];

    if (!array_key_exists($command, $allowedCommands)) {
        abort(403, 'Command not allowed.');
    }

    Artisan::call($allowedCommands[$command]);
    return response()->json(['status' => 'success', 'message' => 'Command executed: ' . $allowedCommands[$command]]);
});
Route::get('/', [HomeController::class, 'index'])->name('front.home');
Route::get('/about', [HomeController::class, 'about'])->name('front.about');
Route::get('/shop', [HomeController::class, 'shop'])->name('front.shop');
Route::get('/category/{unique_id}/{slug}', [HomeController::class, 'category'])->name('front.category');
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

Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('redirectToGoogle');

Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
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

Route::get('/my-account', [AccountController::class, 'index'])->name('myaccount');
Route::post('/account-update/{id}', [AccountController::class, 'update'])->name('user.updateProfile');
Route::get('/order/detail/{id}', [AccountController::class, 'order_detail'])->name('user.order.details');
Route::get('/order/list/data', [AccountController::class, 'getOrderList'])->name('order.get.data');

// wallet
Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
Route::post('/wallet/topup', [WalletController::class, 'topUp'])->name('wallet.topup');
Route::get('/wallet/stripe/success', [WalletController::class, 'handleStripeSuccess'])->name('wallet.stripe.success');
Route::get('/wallet/paydibs/success', [WalletController::class, 'handlePaydibsSuccess'])->name('wallet.paydibs.success');
Route::get('/wallet/transactions/data', [WalletController::class, 'getWalletTransactions'])->name('wallet.transactions.data');

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
            Route::get('/view/{id}', [UserController::class, 'view'])->name('admin.user.view');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('admin.user.update');
            Route::post('/status/{id}', [UserController::class, 'status'])->name('admin.user.status');
            Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
            Route::post('/toggle-suspend', [UserController::class, 'toggleSuspend'])->name('admin.user.toggle_suspend');
        });
        // gift card inventory management
        Route::get('/gift-card-codes', [GiftCardCodeController::class, 'list'])->name('admin.code.list');
        Route::get('/gift-card-codes/get', [GiftCardCodeController::class, 'get'])->name('admin.code.get');
        Route::prefix('gift-card-code')->group(function () {
            Route::get('/add', [GiftCardCodeController::class, 'add'])->name('admin.code.add');
            Route::post('/store', [GiftCardCodeController::class, 'store'])->name('admin.code.store');
            Route::get('/edit/{id}', [GiftCardCodeController::class, 'edit'])->name('admin.code.edit');
            Route::put('/update/{id}', [GiftCardCodeController::class, 'update'])->name('admin.code.update');
            Route::post('/status/{id}', [GiftCardCodeController::class, 'status'])->name('admin.code.status');
            Route::delete('/delete/{id}', [GiftCardCodeController::class, 'destroy'])->name('admin.code.destroy');
            Route::get('/get-product-variants/{id}', [GiftCardCodeController::class, 'getProductVariants'])->name('admin.code.variants');
        });
        Route::get('/orders', [ManageOrderController::class, 'list'])->name('admin.orders.list');
        Route::get('/orders/get', [ManageOrderController::class, 'get'])->name('admin.orders.get');
        Route::get('/order/details/{id}', [ManageOrderController::class, 'detail'])->name('admin.order.details');
        Route::post('/order/status/{id}', [ManageOrderController::class, 'status'])->name('admin.order.status');

        // wallet
        Route::get('/wallet/topups/get', [WalletTopupController::class, 'get'])->name('admin.wallet.get');
        Route::get('/wallet/topups', [WalletTopupController::class, 'list'])->name('admin.wallet.list');
        Route::get('/wallet/topups/{id}', [WalletTopupController::class, 'show'])->name('admin.wallet.show');
        Route::post('/wallet/topups/{id}/approve', [WalletTopupController::class, 'approve'])->name('admin.wallet.approve');
    });
});
