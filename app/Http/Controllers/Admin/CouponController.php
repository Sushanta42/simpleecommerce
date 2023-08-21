<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::all();

        $now = Carbon::now();

        foreach ($coupons as $coupon) {
            if ($coupon->status === 'active' && $coupon->max_uses > 0 && $coupon->used >= $coupon->max_uses) {
                $coupon->status = 'expired';
                $coupon->save();
            } elseif ($coupon->valid_to < $now && $coupon->status !== 'expired') {
                $coupon->status = 'expired';
                $coupon->save();
            } elseif ($coupon->status === 'inactive' && $coupon->valid_from <= $now) {
                $coupon->status = 'active';
                $coupon->save();
            }
        }

        return view('admin.coupon.index', compact('coupons'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.coupon.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|max:255', // Add validation rules for code field
            'discount_amount' => 'required|max:255', // Add validation rules for discount_amount field
            'max_uses' => 'required|max:255', // Add validation rules for max_uses field
            // 'used' => 'required|max:255', // Add validation rules for used field
            'valid_from' => 'required|max:255', // Add validation rules for valid_from field
            'valid_to' => 'required|max:255', // Add validation rules for valid_to field
            // 'active' => 'required',
        ], [
            'code.required' => 'The code field is required.', // Custom error message for name field
            'discount_amount.required' => 'The discount_amount field is required.', // Custom error message for name field
            'max_uses.required' => 'The max_uses field is required.', // Custom error message for name field
            // 'used.required' => 'The used field is required.', // Custom error message for name field
            'valid_from.required' => 'The valid_from field is required.', // Custom error message for name field
            'valid_to.required' => 'The valid_to field is required.', // Custom error message for name field
            // 'active.required' => 'The active field is required.', // Custom error message for plan field

        ]);

        try {
            $coupon = new Coupon();
            $coupon->user_id = $request->user_id;
            $coupon->code = $request->code;
            $coupon->description = $request->description;
            $coupon->discount_amount = $request->discount_amount;
            $coupon->max_uses = $request->max_uses;
            // $coupon->used = $request->used;
            $coupon->valid_from = $request->valid_from;
            $coupon->valid_to = $request->valid_to;
            $now = Carbon::now();
            if ($coupon->valid_from <= $now && $coupon->valid_to >= $now) {
                $coupon->status = 'active';
            } elseif ($coupon->valid_to < $now) {
                $coupon->status = 'inactive';
            } else {
                $coupon->status = 'inactive';
            }

            $coupon->save();
            Session::flash('success', 'Coupon added successfully!'); // Add success message to flash session
            return redirect()->route('coupon.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to add Coupon. Coupon code already exists.');
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
        $coupon = Coupon::find($id);
        $users = User::all();
        return view('admin.coupon.edit', compact('coupon', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            //'code' => 'required|max:255', // Add validation rules for code field
            'discount_amount' => 'required|max:255', // Add validation rules for discount_amount field
            'max_uses' => 'required|max:255', // Add validation rules for max_uses field
            // 'used' => 'required|max:255', // Add validation rules for used field
            'valid_from' => 'required|max:255', // Add validation rules for valid_from field
            'valid_to' => 'required|max:255', // Add validation rules for valid_to field
            // 'status' => 'required',

        ], [
            //'code.required' => 'The code field is required.', // Custom error message for name field
            'discount_amount.required' => 'The discount_amount field is required.', // Custom error message for name field
            'max_uses.required' => 'The max_uses field is required.', // Custom error message for name field
            // 'used.required' => 'The used field is required.', // Custom error message for name field
            'valid_from.required' => 'The valid_from field is required.', // Custom error message for name field
            'valid_to.required' => 'The valid_to field is required.', // Custom error message for name field
            // 'status.required' => 'The active field is required.', // Custom error message for plan field

        ]);

        try {
            $coupon = Coupon::find($id);
            $coupon->user_id = $request->user_id;
            //$coupon->code = $request->code;
            $coupon->description = $request->description;
            $coupon->discount_amount = $request->discount_amount;
            $coupon->max_uses = $request->max_uses;
            // $coupon->used = $request->used;
            $coupon->valid_from = $request->valid_from;
            $coupon->valid_to = $request->valid_to;
            $now = Carbon::now();
            if ($coupon->valid_from <= $now && $coupon->valid_to >= $now) {
                $coupon->status = 'active';
            } elseif ($coupon->valid_to < $now) {
                $coupon->status = 'inactive';
            } else {
                $coupon->status = 'inactive';
            }


            $coupon->update();
            Session::flash('success', 'Coupon added successfully!'); // Add success message to flash session
            return redirect()->route('coupon.index');
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
            $coupon = Coupon::findOrFail($id);
            $coupon->delete();
            return redirect()->route('coupon.index')->with('error', 'Coupon deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
