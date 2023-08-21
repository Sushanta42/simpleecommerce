<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $terms = Term::all();
        return view('admin.term.index', compact('terms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.term.create');
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
            $term = new Term();
            $term->description = $request->description;

            $term->save();
            Session::flash('success', 'Terms and Condition added successfully!'); // Add success message to flash session
            return redirect()->route('terms.index');
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
        $term = Term::find($id);
        return view('admin.term.edit', compact('term'));
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
            $term = Term::find($id);
            $term->description = $request->description;

            $term->update();
            Session::flash('success', 'Terms and Conditions Updated successfully!'); // Add success message to flash session
            return redirect()->route('terms.index');
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
            $term = Term::findOrFail($id);
            $term->delete();
            return redirect()->route('terms.index')->with('error', 'Terms and Condtions deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete terms and conditions');
        }
    }
}
