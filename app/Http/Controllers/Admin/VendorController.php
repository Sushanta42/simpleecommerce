<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommonAddress;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $vendors = Vendor::query()
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('phone', 'LIKE', "%{$search}%")
            ->get();
        return view('admin.vendor.index', compact('vendors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $commonaddresses = CommonAddress::all();
        return view('admin.vendor.create', compact('commonaddresses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:vendors,email',
            'phone' => 'required|unique:vendors,phone',
            'password' => 'required|min:8',
        ]);

        try {
            // Create a new vendor instance
            $vendor = new Vendor();
            $vendor->name = $request->input('name');
            $vendor->email = $request->input('email');
            $vendor->phone = $request->input('phone');
            $vendor->common_address_id = $request->common_address_id;
            $vendor->password = bcrypt($request->input('password'));

            $vendor->save();
            Session::flash('success', 'Vendor added successfully!'); // Add success message to flash session
            return redirect()->route('uservendor.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to add vendor. Vendor name already exists.');
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
        $vendor = Vendor::find($id);
        $commonaddresses = CommonAddress::all();
        return view('admin.vendor.edit', compact('vendor', 'commonaddresses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        try {
            // Create a new vendor instance
            $vendor = Vendor::find($id);
            $vendor->name = $request->name;
            $vendor->email = $request->email;
            $vendor->phone = $request->phone;
            $vendor->common_address_id = $request->common_address_id;

            $vendor->update();
            Session::flash('success', 'Vendor updated successfully!'); // Add success message to flash session
            return redirect()->route('uservendor.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to update vendor. Please check the form data and try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $vendor = Vendor::findOrFail($id);
            $vendor->delete();
            return redirect()->route('uservendor.index')->with('error', 'Vendor deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete vendor');
        }
    }
}
