<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::all();
        return view('admin.useraddress.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.useraddress.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'municipality' => 'required|max:255', // Add validation rules for municipality field
            'city' => 'required|max:255', // Add validation rules for city field
            'ward' => 'required|max:255', // Add validation rules for ward field
            'tole' => 'required|max:255', // Add validation rules for tole field
            'coordinate' => 'required|max:255', // Add validation rules for coordinate field
            'house_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
            'road_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
        ], [
            'municipality.required' => 'The Address municipality field is required.', // Custom error message for name field
            'city.required' => 'The Address city field is required.', // Custom error message for name field
            'ward.required' => 'The Address ward field is required.', // Custom error message for name field
            'tole.required' => 'The Address tole field is required.', // Custom error message for name field
            'house_image.required' => 'The image field is required.', // Custom error message for image field
            'house_image.image' => 'The file must be an image.', // Custom error message for image file type
            'house_image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'house_image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
            'road_image.required' => 'The image field is required.', // Custom error message for image field
            'road_image.image' => 'The file must be an image.', // Custom error message for image file type
            'road_image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'road_image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
        ]);

        try {
            $useraddress = new Address();
            $useraddress->user_id = $request->user_id;
            $useraddress->municipality = $request->municipality;
            $useraddress->city = $request->city;
            $useraddress->ward = $request->ward;
            $useraddress->tole = $request->tole;
            $useraddress->coordinate = $request->coordinate;
            $useraddress->longitude = $request->longitude;
            $useraddress->latitude = $request->latitude;

            //House Image Upload Code
            uploadHouseImage($request, $useraddress, 'house_image');

            //House Image Upload Code
            uploadRoadImage($request, $useraddress, 'road_image');

            $useraddress->save();
            Session::flash('success', 'user Address added successfully!'); // Add success message to flash session
            return redirect()->route('useraddress.index');
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
        $useraddress = Address::find($id);
        $users = User::all();
        return view('admin.useraddress.view', compact('useraddress', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $useraddress = Address::find($id);
        $users = User::all();
        return view('admin.useraddress.edit', compact('useraddress', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'municipality' => 'required|max:255', // Add validation rules for municipality field
            'city' => 'required|max:255', // Add validation rules for city field
            'ward' => 'required|max:255', // Add validation rules for ward field
            'tole' => 'required|max:255', // Add validation rules for tole field
            'coordinate' => 'required|max:255', // Add validation rules for coordinate field
            'house_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
            'road_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
        ], [
            'municipality.required' => 'The Address municipality field is required.', // Custom error message for name field
            'city.required' => 'The Address city field is required.', // Custom error message for name field
            'ward.required' => 'The Address ward field is required.', // Custom error message for name field
            'tole.required' => 'The Address tole field is required.', // Custom error message for name field
            'house_image.image' => 'The file must be an image.', // Custom error message for image file type
            'house_image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'house_image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
            'road_image.image' => 'The file must be an image.', // Custom error message for image file type
            'road_image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'road_image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
        ]);
        try {
            $useraddress = Address::find($id);
            $useraddress->user_id = $request->user_id;
            $useraddress->municipality = $request->municipality;
            $useraddress->city = $request->city;
            $useraddress->ward = $request->ward;
            $useraddress->tole = $request->tole;
            $useraddress->coordinate = $request->coordinate;
            $useraddress->longitude = $request->longitude;
            $useraddress->latitude = $request->latitude;

            //House Image Upload Code
            uploadHouseImage($request, $useraddress, 'house_image');

            //House Image Upload Code
            uploadRoadImage($request, $useraddress, 'road_image');

            $useraddress->update();
            Session::flash('success', 'User Address updated successfully!'); // Add success message to flash session
            return redirect()->route('useraddress.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to update user address. Address name already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $useraddress = Address::findOrFail($id);
            $file = public_path($useraddress->house_image);
            if (file_exists($file)) {
                unlink($file);
            }
            $useraddress->delete();
            return redirect()->route('useraddress.index')->with('error', 'User Address deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete address');
        }
    }
}
