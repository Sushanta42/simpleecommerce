<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carousels = Carousel::all();
        return view('admin.carousel.index', compact('carousels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carousel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255', // Add validation rules for name field
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
        ], [
            'name.required' => 'The category name field is required.', // Custom error message for name field
            'image.required' => 'The image field is required.', // Custom error message for image field
            'image.image' => 'The file must be an image.', // Custom error message for image file type
            'image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
        ]);

        try {
            $carousel = new Carousel();
            $carousel->name = $request->name;
            $carousel->description = $request->description;
            $carousel->status = $request->status;
            $carousel->display_on = $request->display_on;
            $carousel->link_to = $request->link_to;

            //Image Upload Code
            uploadCarouselImage($request, $carousel, 'image');

            $carousel->save();
            Session::flash('success', 'carousel added successfully!'); // Add success message to flash session
            return redirect()->route('carousel.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to add carousel. carousel name already exists.');
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
        $carousel = Carousel::find($id);
        return view('admin.carousel.edit', compact('carousel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255', // Add validation rules for name field
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
        ], [
            'name.required' => 'The category name field is required.', // Custom error message for name field
            'image.image' => 'The file must be an image.', // Custom error message for image file type
            'image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
        ]);

        try {
            $carousel = Carousel::find($id);
            $carousel->name = $request->name;
            $carousel->description = $request->description;
            $carousel->status = $request->status;
            $carousel->display_on = $request->display_on;
            $carousel->link_to = $request->link_to;

            //Image Upload Code
            uploadCarouselImage($request, $carousel, 'image');

            $carousel->update();
            Session::flash('success', 'carousel updated successfully!'); // Add success message to flash session
            return redirect()->route('carousel.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to add carousel. carousel name already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $carousel = Carousel::findOrFail($id);
            $file = public_path($carousel->image);
            if (file_exists($file)) {
                unlink($file);
            }
            $carousel->delete();
            return redirect()->route('carousel.index')->with('error', 'Carousel deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete carousel');
        }
    }
}
