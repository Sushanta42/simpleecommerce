<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryUserResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;

class CategoryApiController extends Controller
{
    //get categories
    public function getCategories()
    {
        $categories = Category::with('subcategories.products')->get();
        return CategoryResource::collection($categories);
    }

    //get category by id
    // public function getCategory($id)
    // {
    //     $category = Category::with('subcategories.products')->find($id);
    //     return CategoryResource::collection([$category]); // Wrap the category in an array
    // }

    public function getCategory($id)
    {
        $category = Category::findOrFail($id);
        $products = $category->subcategories()->with('products')->get()->pluck('products')->flatten();
        return ProductResource::collection($products);
    }

    public function getSubCategory($id)
    {
        $products = Product::where('sub_category_id', $id)->get();
        return ProductResource::collection($products);
    }


    //get subcategories
    public function getSubCategories()
    {
        $subcategories = SubCategory::with('products')->get();
        return SubCategoryResource::collection($subcategories);
    }

    public function getCategoriesByCommonAddress()
    {
        $user = Auth::user();
        $common_address_id = $user->common_address_id;

        $categories = Category::whereHas('subcategories.products.vendor', function ($query) use ($common_address_id) {
            $query->where('common_address_id', $common_address_id);
        })
            ->with(['subcategories' => function ($query) use ($common_address_id) {
                $query->whereHas('products.vendor', function ($query) use ($common_address_id) {
                    $query->where('common_address_id', $common_address_id);
                })->with(['products' => function ($query) use ($common_address_id) {
                    $query->whereHas('vendor', function ($query) use ($common_address_id) {
                        $query->where('common_address_id', $common_address_id);
                    });
                }]);
            }])
            ->get();

        return CategoryUserResource::collection($categories);
    }
}
