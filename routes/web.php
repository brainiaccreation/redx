<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

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


Route::post('/email/verification-notification', 
    [EmailVerificationController::class, 'send']
)->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

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
        });
        Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    });
});
