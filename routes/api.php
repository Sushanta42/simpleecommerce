<?php

use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\CouponApiController;
use App\Http\Controllers\Api\LegalApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\SubscriptionApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\UserMilestoneApiController;
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
    Route::put('cart/{id}', [ProductApiController::class, 'updateCart']);
    Route::delete('cart/{id}', [ProductApiController::class, 'deleteCart']);

    Route::post('usersubscription', [SubscriptionApiController::class, 'addUserSubscription']);
    Route::get('usersubscription', [SubscriptionApiController::class, 'getUserSubscription']);

    Route::get('usermilestone', [UserMilestoneApiController::class, 'getUserMilestone']);

    Route::post('changepassword', [UserApiController::class, 'changePassword']);


    Route::post('order', [ProductApiController::class, 'order']);
    Route::get('order', [ProductApiController::class, 'getOrder']);


    Route::get('categories/user', [CategoryApiController::class, 'getCategoriesByCommonAddress']);
    Route::get('products/user', [ProductApiController::class, 'getProductsByCommonAddress']);
    Route::get('subcategories/user', [CategoryApiController::class, 'getSubCategoriesByCommonAddress']);
    Route::get('category/user/{id}', [CategoryApiController::class, 'getCategoryByCommonAddress']);
    Route::get('subcategory/user/{id}', [CategoryApiController::class, 'getSubCategoryByCommonAddress']);
    Route::get('products/user/hot', [ProductApiController::class, 'getHotProductsByCommonAddress']);
    Route::get('products/user/sale', [ProductApiController::class, 'getSaleProductsByCommonAddress']);
    Route::get('products/user/new', [ProductApiController::class, 'getNewProductsByCommonAddress']);

    Route::get('products/search/user', [ProductApiController::class, 'searchProductsByCommonAddress']);

    Route::post('coupon', [CouponApiController::class, 'addCouponUser']);
    Route::post('/cart/apply-coupon', [ProductApiController::class, 'applyCoupon']);
    Route::get('coupon', [CouponApiController::class, 'getCoupon']);
});

Route::post('register', [UserApiController::class, 'registerUser']);
Route::post('login', [UserApiController::class, 'loginUser']);
Route::get('commonaddresses', [UserApiController::class, 'getCommonAddresses']);
Route::get('categories', [CategoryApiController::class, 'getCategories']);
Route::get('category/{id}', [CategoryApiController::class, 'getCategory']);
Route::get('subcategories', [CategoryApiController::class, 'getSubCategories']);
Route::get('subcategory/{id}', [CategoryApiController::class, 'getSubCategory']);
Route::get('products', [ProductApiController::class, 'getProducts']);
Route::get('product/{id}', [ProductApiController::class, 'getProduct']);
Route::get('products/search', [ProductApiController::class, 'searchProducts']);
Route::get('products/hot', [ProductApiController::class, 'getHotProducts']);
Route::get('products/sale', [ProductApiController::class, 'getSaleProducts']);
Route::get('products/new', [ProductApiController::class, 'getNewProducts']);

Route::get('carousels/home', [LegalApiController::class, 'getCarouselsHome']);
Route::get('carousels/sub', [LegalApiController::class, 'getCarouselsSub']);

Route::get('subscriptions', [SubscriptionApiController::class, 'getSubscriptions']);
Route::get('subscription/{id}', [SubscriptionApiController::class, 'getSubscription']);

Route::get('faqs', [LegalApiController::class, 'getFaqs']);
Route::get('termsandconditions', [LegalApiController::class, 'getTerms']);
Route::get('privacypolicies', [LegalApiController::class, 'getPrivacy']);
Route::get('aboutus', [LegalApiController::class, 'getAboutUs']);
