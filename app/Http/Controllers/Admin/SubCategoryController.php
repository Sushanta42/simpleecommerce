<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;



class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $subcategories = SubCategory::all();
        return view('admin.subcategory.index', compact('subcategories'));
        // $search = $request->input('search');
        // $subcategories = SubCategory::query()
        //     ->where('name', 'LIKE', "%{$search}%")
        //     ->get();
        // return view('admin.subcategory.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategory.create', compact('categories'));
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
            $subcategory = new SubCategory();
            $subcategory->name = $request->name;
            $subcategory->slug = Str::slug($request->name);
            $subcategory->category_id = $request->category_id;

            //Image Upload Code

            uploadSubImage($request, $subcategory, 'image');

            $subcategory->save();
            Session::flash('success', 'SubCategory added successfully!'); // Add success message to flash session
            return redirect()->route('subcategory.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to add category. Category name already exists.');
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
        $subcategory = SubCategory::find($id);
        $categories = Category::all();
        return view('admin.subcategory.edit', compact('subcategory', 'categories'));
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
            $subcategory = SubCategory::find($id);
            $subcategory->name = $request->name;
            $subcategory->slug = Str::slug($request->name);
            $subcategory->category_id = $request->category_id;

            //Image Upload Code

            uploadImage($request, $subcategory, 'image');

            $subcategory->update();
            Session::flash('success', 'SubCategory updated successfully!'); // Add success message to flash session
            return redirect()->route('subcategory.index');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to update category. Category name already exists.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     try {
    //         $subcategory = SubCategory::findOrFail($id);
    //         $file = public_path($subcategory->image);
    //         if (file_exists($file)) {
    //             unlink($file);
    //         }
    //         $subcategory->delete();
    //         return redirect()->route('subcategory.index')->with('error', 'SubCategory deleted successfully.');
    //     } catch (\Exception $e) {
    //         // Handle the exception and show error message
    //         return redirect()->back()->with('error', 'Failed to delete subcategory');
    //     }
    // }
    public function destroy(string $id)
    {
        try {
            $subcategory = SubCategory::findOrFail($id);

            // Check if the subcategory has related products
            if ($subcategory->products()->exists()) {
                return redirect()->back()->with('error', 'Failed to delete subcategory due to its relation in products');
            }

            // Get the file path and delete the image only if subcategory is deleted
            $file = public_path($subcategory->image);

            // Delete the subcategory first
            $subcategory->delete();

            // Delete the image file only if subcategory deletion was successful
            if (file_exists($file)) {
                unlink($file);
            }

            return redirect()->route('subcategory.index')->with('success', 'Subcategory deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete subcategory. ' . $e->getMessage());
        }
    }
}
