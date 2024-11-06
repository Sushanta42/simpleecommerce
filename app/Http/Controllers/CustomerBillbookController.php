<?php

namespace App\Http\Controllers;

use App\Models\Billbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class CustomerBillbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bluebookrenew');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'municipality' => 'required|max:255', // Add validation rules for municipality field
            'address' => 'required|max:255', // Add validation rules for city field
            'image_citizen' => 'image|mimes:jpeg,png,jpg|max:3072', // Add validation rules for image field
            'image_front' => 'image|mimes:jpeg,png,jpg|max:3072', // Add validation rules for image field
            'image' => 'image|mimes:jpeg,png,jpg|max:3072', // Add validation rules for image field
        ], [
            'name.required' => 'The Name field is required.', // Custom error message for name field
            'phone.required' => 'The phone field is required.', // Custom error message for name field
            'municipality.required' => 'The municipality field is required.', // Custom error message for name field
            'address.required' => 'The Address city field is required.', // Custom error message for name field
            'image.image' => 'The file must be an image.', // Custom error message for image file type
            'image.mimes' => 'The file must be a jpeg, png, jpg image.', // Custom error message for image file type
            'image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
            'image_front.image' => 'The file must be an image.', // Custom error message for image file type
            'image_front.mimes' => 'The file must be a jpeg, png, jpg image.', // Custom error message for image file type
            'image_front.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
            'image_citizen.image' => 'The file must be an image.', // Custom error message for image file type
            'image_citizen.mimes' => 'The file must be a jpeg, png, jpg image.', // Custom error message for image file type
            'image_citizen.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
        ]);

        try {
            $billbook = new Billbook();
            $billbook->name = $request->name;
            $billbook->phone = $request->phone;
            $billbook->email = $request->email;
            $billbook->municipality = $request->municipality;
            $billbook->address = $request->address;
            $billbook->vehicle_type = $request->vehicle_type;
            // $billbook->status = $request->status;
            $billbook->renewal_date = $request->renewal_date;
            $billbook->billbook_status = $request->billbook_status;
            $billbook->description = $request->description;

            // Image Upload Code
            uploadImageCitizen($request, $billbook, 'image_citizen');

            // Image Upload Code
            uploadImageFront($request, $billbook, 'image_front');

            // Image Upload Code
            uploadImageMain($request, $billbook, 'image');

            $billbook->save();
            Session::flash('success', 'User bluebook added successfully!'); // Add success message to flash session
            // return redirect()->route('billbook.index');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
