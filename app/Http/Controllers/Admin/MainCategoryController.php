<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MainCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class MainCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maincategories = MainCategory::with('categories')->get();
        return view('admin.maincategory.index', compact('maincategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.maincategory.create');
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
            $maincategory = new MainCategory();
            $maincategory->name = $request->name;
            //Image Upload Code

            uploadMainImage($request, $maincategory, 'image');

            $maincategory->save();
            Session::flash('success', 'Category added successfully!'); // Add success message to flash session
            return redirect()->route('maincategory.index');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $maincategory = MainCategory::find($id);
        return view('admin.maincategory.edit', compact('maincategory'));
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
            $maincategory = MainCategory::find($id);
            $maincategory->name = $request->name;

            //Image Upload Code

            uploadImage($request, $maincategory, 'image');

            $maincategory->update();
            Session::flash('success', 'Category updated successfully!'); // Add success message to flash session
            return redirect()->route('maincategory.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to update category. Category name already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $maincategory = MainCategory::findOrFail($id);

            // Check if the main category has subcategories
            if ($maincategory->categories()->exists()) {
                return redirect()->back()->with('error', 'Failed to delete category due to its relation in sub category');
            }

            // Delete the main category
            $maincategory->delete();

            // Delete the image only if the category was successfully deleted
            $file = public_path($maincategory->image);
            if (file_exists($file)) {
                unlink($file);
            }

            return redirect()->route('maincategory.index')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete category. ' . $e->getMessage());
        }
    }

}
