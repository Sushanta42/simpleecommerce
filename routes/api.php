<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('cart', [ProductApiController::class, 'addToCart']);
    Route::get('cart', [ProductApiController::class, 'getCart']);

    Route::post('order', [ProductApiController::class, 'order']);

    Route::get('categories/user', [CategoryApiController::class, 'getCategoriesByCommonAddress']);
    Route::get('products/user', [ProductApiController::class, 'getProductsByCommonAddress']);
});

Route::post('register', [UserApiController::class, 'registerUser']);
Route::post('login', [UserApiController::class, 'loginUser']);
Route::get('categories', [CategoryApiController::class, 'getCategories']);
Route::get('subcategories', [CategoryApiController::class, 'getSubCategories']);
Route::get('products', [ProductApiController::class, 'getProducts']);
Route::get('product/{id}', [ProductApiController::class, 'getProduct']);
