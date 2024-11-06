<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Billbook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;


class BillbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $billbooks = Billbook::all();
        foreach ($billbooks as $billbook) {
            $this->updateBillbookStatus($billbook);
        }
        return view('admin.billbook.index', compact('billbooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.billbook.create');
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
            'image_citizen' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Add validation rules for image field
            'image_front' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Add validation rules for image field
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Add validation rules for image field
        ], [
            'name.required' => 'The Name field is required.', // Custom error message for name field
            'phone.required' => 'The phone field is required.', // Custom error message for name field
            'municipality.required' => 'The Address municipality field is required.', // Custom error message for name field
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
            $billbook->status = $request->status;
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
            Session::flash('success', 'user bluebook added successfully!'); // Add success message to flash session
            return redirect()->route('billbook.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $billbook = Billbook::find($id);
        return view('admin.billbook.view', compact('billbook'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $billbook = Billbook::find($id);
        return view('admin.billbook.edit', compact('billbook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'municipality' => 'required|max:255', // Add validation rules for municipality field
            'address' => 'required|max:255', // Add validation rules for city field
            'image_citizen' => 'image|mimes:jpeg,png,jpg|max:2048', // Add validation rules for image field
            'image_front' => 'image|mimes:jpeg,png,jpg|max:2048', // Add validation rules for image field
            'image' => 'image|mimes:jpeg,png,jpg|max:2048', // Add validation rules for image field
        ], [
            'name.required' => 'The Name field is required.', // Custom error message for name field
            'phone.required' => 'The phone field is required.', // Custom error message for name field
            'municipality.required' => 'The Address municipality field is required.', // Custom error message for name field
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
            $billbook = Billbook::find($id);
            $billbook->name = $request->name;
            $billbook->phone = $request->phone;
            $billbook->email = $request->email;
            $billbook->municipality = $request->municipality;
            $billbook->address = $request->address;
            $billbook->vehicle_type = $request->vehicle_type;
            $billbook->status = $request->status;
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
            Session::flash('success', 'user bluebook updated successfully!'); // Add success message to flash session
            // return redirect()->route('billbook.index');
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $billbook = Billbook::findOrFail($id);
            $filess = public_path($billbook->image_citizen);
            $file = public_path($billbook->image_front);
            $files = public_path($billbook->image);
            if (file_exists($filess)) {
                unlink($filess);
            }
            if (file_exists($file)) {
                unlink($file);
            }
            if (file_exists($files)) {
                unlink($files);
            }
            $billbook->delete();
            return redirect()->route('billbook.index')->with('error', 'User Bluebook deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete address');
        }
    }
    /**
     * Update the billbook status based on the renewal_date.
     */
    private function updateBillbookStatus($billbook)
    {
        if ($billbook->renewal_date) {
            $currentDate = Carbon::now();
            $renewalDate = Carbon::parse($billbook->renewal_date);

            if ($currentDate->greaterThanOrEqualTo($renewalDate)) {
                $billbook->billbook_status = 'expiry';
            } elseif ($currentDate->diffInDays($renewalDate, false) <= 7) {
                $billbook->billbook_status = 'notice_time';
            } else {
                $billbook->billbook_status = 'active';
            }

            $billbook->save();
        }
    }
}
