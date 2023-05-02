<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommonAddress;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::all();
        return view('admin.customer.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $commonaddresses = CommonAddress::all();
        return view('admin.customer.create', compact('commonaddresses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'password' => 'required|min:8',
        ]);

        try {
            // Create a new user instance
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->common_address_id = $request->common_address_id;
            $user->password = bcrypt($request->input('password'));

            $user->save();
            Session::flash('success', 'User added successfully!'); // Add success message to flash session
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to add user. user name already exists.');
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
        $user = User::find($id);
        $commonaddresses = CommonAddress::all();
        return view('admin.customer.edit', compact('user', 'commonaddresses'));
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
            // Create a new user instance
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->common_address_id = $request->common_address_id;

            $user->update();
            Session::flash('success', 'User updated successfully!'); // Add success message to flash session
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to update user. Please check the form data and try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return redirect()->route('user.index')->with('error', 'User deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete user');
        }
    }
}
