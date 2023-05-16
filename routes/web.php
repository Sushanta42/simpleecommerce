<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommonAddressController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserSubscriptionController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserProductController;
use App\Http\Controllers\Vendor\ProductController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('user/userproduct', UserProductController::class);
});

require __DIR__ . '/auth.php';


// Admin routes
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth:admin', 'verified'])->name('admin.dashboard');

Route::middleware('auth:admin')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('category', CategoryController::class);
    Route::resource('subcategory', SubCategoryController::class);
    Route::resource('order', OrderController::class);


    Route::resource('user', UserController::class);
    Route::resource('uservendor', VendorController::class);
    Route::resource('commonaddress', CommonAddressController::class);
    Route::resource('subscription', SubscriptionController::class);
    Route::resource('usersubscription', UserSubscriptionController::class);
});

require __DIR__ . '/adminauth.php';


// Vendor routes
Route::get('/vendor/dashboard', function () {
    return view('vendor.dashboard');
})->middleware(['auth:vendor', 'verified'])->name('vendor.dashboard');

Route::middleware('auth:vendor')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('vendor/product', ProductController::class);
});

require __DIR__ . '/vendorauth.php';
