<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UserFamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userfamilies = Family::all();
        return view('admin.userfamily.index', compact('userfamilies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.userfamily.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:users,phone',
            'dob' => 'required',
        ]);

        try {
            // Create a new user instance
            $userfamily = new Family();
            $userfamily->user_id = $request->user_id;
            $userfamily->name = $request->name;
            $userfamily->phone = $request->phone;
            $userfamily->mobile = $request->mobile;
            $userfamily->dob = $request->dob;

            $userfamily->save();
            Session::flash('success', 'User Family added successfully!'); // Add success message to flash session
            return redirect()->route('userfamily.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to add user family!');
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
        $users = User::find($id);
        return view('admin.userfamily.edit', compact('users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:users,phone',
            'dob' => 'required',
        ]);

        try {
            $userfamily = Family::find($id);
            $userfamily->user_id = $request->user_id;
            $userfamily->name = $request->name;
            $userfamily->phone = $request->phone;
            $userfamily->mobile = $request->mobile;
            $userfamily->dob = $request->dob;

            $userfamily->update();
            Session::flash('success', 'User Family updated successfully!'); // Add success message to flash session
            return redirect()->route('userfamily.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to add user family!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $userfamily = Family::findOrFail($id);
            $userfamily->delete();
            return redirect()->route('userfamily.index')->with('error', 'User Family detail deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete user');
        }
    }
}
