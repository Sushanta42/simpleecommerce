<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommonAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class CommonAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commonaddresses = CommonAddress::all();
        return view('admin.commonaddress.index', compact('commonaddresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.commonaddress.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255', // Add validation rules for name field
        ], [
            'name.required' => 'The Address name field is required.', // Custom error message for name field
        ]);

        try {
            $commonaddress = new CommonAddress();
            $commonaddress->name = $request->name;

            $commonaddress->save();
            Session::flash('success', 'Common Address added successfully!'); // Add success message to flash session
            return redirect()->route('commonaddress.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to add common address. Address name already exists.');
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
        $commonaddress = CommonAddress::find($id);
        return view('admin.commonaddress.edit', compact('commonaddress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255', // Add validation rules for name field
        ], [
            'name.required' => 'The Address name field is required.', // Custom error message for name field
        ]);

        try {
            $commonaddress = CommonAddress::find($id);
            $commonaddress->name = $request->name;

            $commonaddress->update();
            Session::flash('success', 'Common Address updated successfully!'); // Add success message to flash session
            return redirect()->route('commonaddress.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to update common address. Address name already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $commonaddress = CommonAddress::findOrFail($id);
            $commonaddress->delete();
            return redirect()->route('commonaddress.index')->with('error', 'Common Address deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete Common Address Due to it relation with users/vendors.');
        }
    }
}
