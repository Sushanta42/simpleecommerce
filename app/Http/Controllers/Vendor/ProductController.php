<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where('vendor_id', Auth::id())->get();
        return view('vendor.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = SubCategory::all();
        $categories = Category::all();
        return view('vendor.product.create', compact('subcategories', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255', // Add validation rules for name field
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric|lte:price',
            'category_id' => 'required',
            'discount_percent' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240', // 10MB max for media files
        ], [
            'name.required' => 'The Product name field is required.', // Custom error message for name field
            'price.required' => 'The price field is required.', // Custom error message for price field
            'sale_price.required' => 'The Selling price field is required.', // Custom error message for price field
            'sale_price.lte' => 'The Selling price must be equal to or less than the regular price.', // Custom error message for sale_price validation
            'category_id.required' => 'The Category field is required.', // Custom error message for price field
            'discount_percent.required' => 'The discount percent field is required.', // Custom error message for price field
            'image.required' => 'The image field is required.', // Custom error message for image field
            'image.image' => 'The file must be an image.', // Custom error message for image file type
            'image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
        ]);
        try {
            $product = new Product();
            $product->name = $request->name;
            $product->price = $request->price;
            $product->discount_percent = $request->discount_percent;
            $product->sale_price = $request->sale_price;
            $product->description = $request->description;
            $product->availability = $request->availability;
            $product->slug = Str::slug($request->name) . '-' . Auth::user()->id;
            $product->category_id = $request->category_id;
            $product->sub_category_id = $request->subcategory_id;
            $product->vendor_id = Auth::user()->id;

            //Image Upload Code

            uploadProductImage($request, $product, 'image');

            $product->save();
            // Handle additional media files
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $newName = time() . '_' . $file->getClientOriginalName();
                    $file->move("images/media", $newName);
                    $filePath = "images/media/$newName";
                    $fileType = $file->getClientOriginalExtension() == 'mp4' ? 'video' : 'image';

                    $media = new ProductMedia();
                    $media->product_id = $product->id;
                    $media->file_path = $filePath;
                    $media->media_type = $fileType;
                    $media->save();
                }
            }
            Session::flash('success', 'Product added successfully!'); // Add success message to flash session
            return redirect()->route('product.index');
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
        $product = Product::find($id);
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('vendor.product.view', compact('product', 'subcategories', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('vendor.product.edit', compact('product', 'subcategories', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|max:255', // Add validation rules for name field
            'price' => 'required|numeric',
            'sale_price' => 'required|numeric|lte:price',
            'discount_percent' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation rules for image field
            'media.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240', // 10MB max for media files
        ], [
            'name.required' => 'The Product name field is required.', // Custom error message for name field
            'price.required' => 'The price field is required.', // Custom error message for price field
            'sale_price.required' => 'The Selling price field is required.', // Custom error message for price field
            'sale_price.lte' => 'The Selling price must be equal to or less than the regular price.', // Custom error message for sale_price validation
            'discount_percent.required' => 'The discount percent field is required.', // Custom error message for price field
            'image.image' => 'The file must be an image.', // Custom error message for image file type
            'image.mimes' => 'The file must be a jpeg, png, jpg, or gif image.', // Custom error message for image file type
            'image.max' => 'The image may not be greater than 2MB.', // Custom error message for image file size
        ]);
        try {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->price = $request->price;
            $product->discount_percent = $request->discount_percent;
            $product->sale_price = $request->sale_price;
            $product->description = $request->description;
            $product->availability = $request->availability;
            if (!empty($request->label)) {
                $product->label = $request->label;
            }
            $product->slug = Str::slug($request->name) . '-' . Auth::user()->id;
            $product->sub_category_id = $request->subcategory_id;
            $product->category_id = $request->category_id;
            $product->vendor_id = Auth::user()->id;

            //Image Upload Code

            uploadProductImage($request, $product, 'image');

            $product->update();
            // Handle additional media files
            if ($request->hasFile('media')) {
                foreach ($request->file('media') as $file) {
                    $newName = time() . '.' . $file->getClientOriginalExtension();
                    $file->move("images/media", $newName);
                    $filePath = "images/media/$newName";
                    $fileType = $file->getClientOriginalExtension() == 'mp4' ? 'video' : 'image';

                    $media = new ProductMedia();
                    $media->product_id = $product->id;
                    $media->file_path = $filePath;
                    $media->media_type = $fileType;
                    $media->save();
                }
            }
            Session::flash('success', 'Product update successfully!'); // Add success message to flash session
            return redirect()->route('product.index');
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
            $product = Product::findOrFail($id);
            $product->delete();
            $file = public_path($product->image);
            if (file_exists($file)) {
                unlink($file);
            }
            // Delete associated media files (if any)
            $mediaFiles = ProductMedia::where('product_id', $product->id)->get();
            foreach ($mediaFiles as $media) {
                $mediaFiles = public_path($media->file_path);
                if (file_exists($mediaFiles)) {
                    unlink($mediaFiles);
                }
                $media->delete();
            }
            return redirect()->route('product.index')->with('error', 'Product deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception and show error message
            return redirect()->back()->with('error', 'Failed to delete product');
        }
    }
    public function deleteMedia(ProductMedia $media)
    {
        try {
            // Delete media file from storage
            $filePath = public_path($media->file_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            // Delete media record from database
            $media->delete();
            return response()->json(['success' => 'Media deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete media.']);
        }
    }
}
