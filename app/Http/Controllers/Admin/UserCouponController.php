<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UserCouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usercoupons = UserCoupon::all();
        return view('admin.usercoupon.index', compact('usercoupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $coupons = Coupon::all();
        return view('admin.usercoupon.create', compact('users', 'coupons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|max:255', // Add validation rules for code field
            'coupon_id' => 'required|max:255', // Add validation rules for discount_amount field
        ], [
            'user_id.required' => 'The user name field is required.', // Custom error message for name field
            'coupon_id.required' => 'The coupon code field is required.', // Custom error message for name field
        ]);
        try {
            $usercoupon = new UserCoupon();
            $usercoupon->user_id = $request->user_id;
            $usercoupon->coupon_id = $request->coupon_id;

            $usercoupon->save();
            Session::flash('success', 'User Coupon added successfully!'); // Add success message to flash session
            return redirect()->route('usercoupon.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usercoupons = UserCoupon::find($id);
        $users = User::all();
        $coupons = Coupon::all();
        return view('admin.usercoupon.edit', compact('usercoupons', 'users', 'coupons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|max:255', // Add validation rules for code field
            'coupon_id' => 'required|max:255', // Add validation rules for discount_amount field
        ], [
            'user_id.required' => 'The user name field is required.', // Custom error message for name field
            'coupon_id.required' => 'The coupon code field is required.', // Custom error message for name field
        ]);
        try {
            $usercoupon = UserCoupon::find($id);
            $usercoupon->user_id = $request->user_id;
            $usercoupon->coupon_id = $request->coupon_id;

            $usercoupon->update();
            Session::flash('success', 'User Coupon added successfully!'); // Add success message to flash session
            return redirect()->route('usercoupon.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $usercoupon = UserCoupon::findOrFail($id);
            $usercoupon->delete();
            return redirect()->route('usercoupon.index')->with('error', 'User Coupon deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
