<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryUserResource;
use App\Http\Resources\MainCategoryUserResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SubCategoryResource;
use App\Models\Category;
use App\Models\MainCategory;
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
        // $category = Category::findOrFail($id);
        // $products = $category->subcategories()->with('products')->get()->pluck('products')->flatten();
        $products = Product::where('category_id', $id)->get();
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

    // public function getCategoriesByCommonAddress()
    // {
    //     $user = Auth::user();
    //     $common_address_id = $user->common_address_id;

    //     $categories = Category::whereHas('subcategories.products.vendor', function ($query) use ($common_address_id) {
    //         $query->where('common_address_id', $common_address_id);
    //     })
    //         ->with(['subcategories' => function ($query) use ($common_address_id) {
    //             $query->whereHas('products.vendor', function ($query) use ($common_address_id) {
    //                 $query->where('common_address_id', $common_address_id);
    //             })->with(['products' => function ($query) use ($common_address_id) {
    //                 $query->whereHas('vendor', function ($query) use ($common_address_id) {
    //                     $query->where('common_address_id', $common_address_id);
    //                 });
    //             }]);
    //         }])
    //         ->get();

    //     return CategoryUserResource::collection($categories);
    // }

    public function getCategoriesByCommonAddress()
    {
        $user = Auth::user();
        $common_address_id = $user->common_address_id;

        $categories = Category::whereHas('subcategories.products.vendor', function ($query) use ($common_address_id) {
            $query->where('common_address_id', $common_address_id);
        })->orWhereHas('products.vendor', function ($query) use ($common_address_id) {
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

    public function getMainCategoriesByCommonAddress()
    {
        $user = Auth::user();
        $common_address_id = $user->common_address_id;

        $mainCategories = MainCategory::whereHas('categories.subcategories.products.vendor', function ($query) use ($common_address_id) {
            $query->where('common_address_id', $common_address_id);
        })->orWhereHas('categories.products.vendor', function ($query) use ($common_address_id) {
            $query->where('common_address_id', $common_address_id);
        })
            ->with(['categories' => function ($query) use ($common_address_id) {
                $query->whereHas('subcategories.products.vendor', function ($query) use ($common_address_id) {
                    $query->where('common_address_id', $common_address_id);
                })->orWhereHas('products.vendor', function ($query) use ($common_address_id) {
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
                    }, 'products' => function ($query) use ($common_address_id) {
                        $query->whereHas('vendor', function ($query) use ($common_address_id) {
                            $query->where('common_address_id', $common_address_id);
                        });
                    }]);
            }])
            ->get();

        return MainCategoryUserResource::collection($mainCategories);
    }


    // Get subcategorybycommonaddress
    public function getSubCategoriesByCommonAddress()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get the common_address_id of the user
        $common_address_id = $user->common_address_id;

        // Retrieve subcategories that have products from vendors with common_address_id matching the user's common_address_id
        $subcategories = SubCategory::whereHas('products.vendor', function ($query) use ($common_address_id) {
            $query->where('common_address_id', $common_address_id);
        })->with(['products' => function ($query) use ($common_address_id) {
            $query->whereHas('vendor', function ($query) use ($common_address_id) {
                $query->where('common_address_id', $common_address_id);
            });
        }])->get();

        return SubCategoryResource::collection($subcategories);
    }

    // Get products in a specific category by common address of user and vendors
    // public function getCategoryByCommonAddress($id)
    // {
    //     // Get the currently authenticated user
    //     $user = Auth::user();

    //     // Get the common_address_id of the user
    //     $common_address_id = $user->common_address_id;

    //     // Retrieve the category with the specified ID
    //     $category = Category::findOrFail($id);

    //     // Retrieve products in the category that have vendors with common_address_id matching the user's common_address_id
    //     $products = $category->subcategories()->whereHas('products.vendor', function ($query) use ($common_address_id) {
    //         $query->where('common_address_id', $common_address_id);
    //     })->with(['products' => function ($query) use ($common_address_id) {
    //         $query->whereHas('vendor', function ($query) use ($common_address_id) {
    //             $query->where('common_address_id', $common_address_id);
    //         });
    //     }])->get()->pluck('products')->flatten();

    //     return ProductResource::collection($products);
    // }
    public function getCategoryByCommonAddress($id)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get the common_address_id of the user
        $common_address_id = $user->common_address_id;

        // Retrieve the category with the specified ID
        $category = Category::findOrFail($id);

        // Retrieve products in the category that have vendors with common_address_id matching the user's common_address_id
        $products = $category->products()->whereHas('vendor', function ($query) use ($common_address_id) {
            $query->where('common_address_id', $common_address_id);
        })->get();

        return ProductResource::collection($products);
    }


    // Get products in a specific subcategory by common address of user and vendors
    public function getSubCategoryByCommonAddress($id)
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Get the common_address_id of the user
        $common_address_id = $user->common_address_id;

        // Retrieve the subcategory with the specified ID
        $subcategory = SubCategory::findOrFail($id);

        // Retrieve products in the subcategory that have vendors with common_address_id matching the user's common_address_id
        $products = $subcategory->products()->whereHas('vendor', function ($query) use ($common_address_id) {
            $query->where('common_address_id', $common_address_id);
        })->get();

        return ProductResource::collection($products);
    }
}
