<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PrivacyPolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $privacypolicies = PrivacyPolicy::all();
        return view('admin.privacypolicy.index', compact('privacypolicies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.privacypolicy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
        ], [
            'description.required' => 'The Description field is required.', // Custom error message for
        ]);
        try {
            $privacypolicy = new PrivacyPolicy();
            $privacypolicy->description = $request->description;

            $privacypolicy->save();
            Session::flash('success', 'Privacy policy added successfully!'); // Add success message to flash session
            return redirect()->route('privacypolicy.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e);
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
        $privacypolicy = PrivacyPolicy::find($id);
        return view('admin.privacypolicy.edit', compact('privacypolicy'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'description' => 'required',
        ], [
            'description.required' => 'The Description field is required.', // Custom error message for
        ]);
        try {
            $privacypolicy = PrivacyPolicy::find($id);
            $privacypolicy->description = $request->description;

            $privacypolicy->update();
            Session::flash('success', 'Privacy Policy Updated successfully!'); // Add success message to flash session
            return redirect()->route('privacypolicy.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $privacypolicy = PrivacyPolicy::findOrFail($id);
            $privacypolicy->delete();
            return redirect()->route('privacypolicy.index')->with('error', 'Privacy Policy deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete Privacy Policy.');
        }
    }
}
