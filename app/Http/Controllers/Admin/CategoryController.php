<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::query()
            ->with('subcategories') // Add this line to eager load the 'subcategories' relationship
            ->where('name', 'LIKE', "%{$search}%")
            ->paginate(5);
        return view('admin.category.index', compact('categories'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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
            $category = new Category();
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);

            //Image Upload Code

            uploadImage($request, $category, 'image');

            $category->save();
            Session::flash('success', 'Category added successfully!'); // Add success message to flash session
            return redirect()->route('category.index');
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
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));
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
            $category = Category::find($id);
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);

            //Image Upload Code

            uploadImage($request, $category, 'image');

            $category->update();
            Session::flash('success', 'Category updated successfully!'); // Add success message to flash session
            return redirect()->route('category.index');
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
            $category = Category::findOrFail($id);
            $file = public_path($category->image);
            if(file_exists($file)){
                unlink($file);
            }
            $category->delete();
            return redirect()->route('category.index')->with('error', 'Category deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete category due to its relation in sub category');
        }
    }
}
