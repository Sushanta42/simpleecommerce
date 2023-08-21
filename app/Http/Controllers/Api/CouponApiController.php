<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResource;
use App\Models\Cart;
use App\Models\UserCoupon;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponApiController extends Controller
{
    public function addCouponUser(Request $request)
    {
        $coupon = Coupon::where('code', $request->coupon_code)->first();
        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Coupon does not exist'], 400);
        }

        // Check if the coupon is inactive or expired
        if ($coupon->status === 'inactive') {
            return response()->json(['success' => false, 'message' => 'Coupon is inactive'], 400);
        }

        if ($coupon->status === 'expired') {
            return response()->json(['success' => false, 'message' => 'Coupon has expired'], 400);
        }

        if ($coupon->max_uses !== null && $coupon->used >= $coupon->max_uses) {
            return response()->json(['success' => false, 'message' => 'Coupon has reached its maximum uses'], 400);
        }

        if ($coupon->user_id !== null && $coupon->user_id !== Auth::user()->id) {
            return response()->json(['success' => false, 'message' => 'This coupon is not valid for the current user'], 400);
        }

        // Check if the coupon is available for all users and has not been used by the current user
        if ($coupon->user_id === null && UserCoupon::where('coupon_id', $coupon->id)->where('user_id', Auth::user()->id)->exists()) {
            return response()->json(['success' => false, 'message' => 'You have already used this coupon'], 400);
        }

        $usercoupon = new UserCoupon();
        $usercoupon->user_id = Auth::user()->id;
        $usercoupon->coupon_id = $coupon->id;
        // $usercoupon->save();

        // Get the total amount of products in the cart
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $totalAmount = $carts->sum('amount');

        // Calculate the discount amount
        $discountAmount = $coupon->discount_amount;

        // Apply the discount amount to the total amount in the cart
        $totalAmount -= $discountAmount;

        // Update the total amount in the cart
        foreach ($carts as $cart) {
            $cart->total_amount = $totalAmount;
            $cart->coupon_discount = $discountAmount;
            $cart->coupon_id = $coupon->id;
            $cart->save();
        }

        // Increment the coupon's usage count
        // $coupon->increment('used');

        return response()->json(['success' => true, 'message' => 'Coupon successfully applied'], 201);
    }



    //getCoupon
    public function getCoupon()
    {
        $coupons = Coupon::where(function ($query) {
            $query->where('user_id', Auth::user()->id)
                ->orWhereNull('user_id');
        })
            ->where('status', 'active')
            ->get();

        return CouponResource::collection($coupons);
    }
}
