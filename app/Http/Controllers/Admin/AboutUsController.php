<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aboutus = AboutUs::all();
        return view('admin.aboutus.index', compact('aboutus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.aboutus.create');
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
            $aboutus = new AboutUs();
            $aboutus->description = $request->description;

            $aboutus->save();
            Session::flash('success', 'Company details added successfully!'); // Add success message to flash session
            return redirect()->route('aboutus.index');
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
        $aboutus = AboutUs::find($id);
        return view('admin.aboutus.edit', compact('aboutus'));
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
            $aboutus = AboutUs::find($id);
            $aboutus->description = $request->description;

            $aboutus->update();
            Session::flash('success', 'Company details Updated successfully!'); // Add success message to flash session
            return redirect()->route('aboutus.index');
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
            $aboutus = AboutUs::findOrFail($id);
            $aboutus->delete();
            return redirect()->route('aboutus.index')->with('error', 'Company details deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete Company details.');
        }
    }
}
