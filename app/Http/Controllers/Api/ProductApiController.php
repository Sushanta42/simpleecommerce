<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserCoupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductApiController extends Controller
{
    //get products
    public function getProducts()
    {
        try {
            $products = Product::all();
            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving products'], 500);
        }
    }

    //get single product
    public function getProduct($id)
    {
        try {
            $product = Product::find($id);
            if (empty($product)) {
                return response()->json(['success' => false, 'message' => 'Product not found'], 404);
            }
            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving the product'], 500);
        }
    }

    //get products by user and vendor common_address
    public function getProductsByCommonAddress()
    {
        try {
            $user = Auth::user();
            $common_address_id = $user->common_address_id;
            $products = Product::whereHas('vendor', function ($query) use ($common_address_id) {
                $query->where('common_address_id', $common_address_id);
            })->get();

            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving products by common address'], 500);
        }
    }


    //add to cart
    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantity;
        $user = Auth::user();

        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($cart) {
            // Update the quantity if the product already exists in the cart
            $cart->quantity += $quantity;
            $cart->amount = $cart->quantity * $request->price;
            $cart->save();
        } else {
            // Create a new cart entry if the product doesn't exist in the cart
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->product_id = $productId;
            $cart->quantity = $quantity;
            $cart->amount = $quantity * $request->price;
            $cart->save();
        }

        // Calculate and update the total_amount of all products in the cart
        $carts = Cart::where('user_id', $user->id)->get();
        $couponDiscount = $carts->first()->coupon_discount;
        $couponId = $carts->first()->coupon_id;
        $totalAmount = $carts->sum('amount') - $couponDiscount;
        foreach ($carts as $cartItem) {
            $cartItem->total_amount = $totalAmount;
            $cartItem->coupon_id = $couponId;
            $cartItem->save();
        }

        return response()->json(['success' => true, 'message' => 'Item added to cart successfully'], 201);
    }


    //get cart
    public function getCart()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();

        // Check if there are any products in the cart
        if ($carts->isEmpty()) {
            return response()->json(['success' => true, 'total_amount' => 0, 'data' => []]);
        }

        // Calculate the itemTotal value for each cart item
        $carts->transform(function ($cart) {
            $cart->itemTotal = $cart->quantity * $cart->product->price;
            return $cart;
        });

        $itemTotal = $carts->sum('itemTotal');
        $discountAmount = $carts->sum('itemTotal') - $carts->sum('amount');
        $totalAmount = $carts->first()->total_amount;
        $couponDiscount = $carts->first()->coupon_discount;



        return response()->json([
            'item_total' => $itemTotal,
            'discount_amount' => $discountAmount,
            'coupon_discount' => $couponDiscount,
            'total_amount' => $totalAmount,
            'data' => CartResource::collection($carts)
        ]);
    }


    // Update cart
    public function updateCart(Request $request, $id)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }

        $cart->quantity = $request->quantity;
        $cart->amount = $cart->quantity * $cart->product->sale_price;
        $cart->save();

        // Calculate and update the total_amount of all products in the cart
        $carts = Cart::where('user_id', $user->id)->get();
        $couponDiscount = $carts->first()->coupon_discount;
        $couponId = $cart->coupon_id;
        $totalAmount = $carts->sum('amount') - $couponDiscount;


        foreach ($carts as $cartItem) {
            $cartItem->coupon_id = $couponId;
            $cartItem->total_amount = $totalAmount;
            $cartItem->coupon_discount = $couponDiscount;
            $cartItem->save();
        }


        return response()->json(['success' => true, 'message' => 'Cart item updated successfully'], 200);
    }


    // Delete cart
    public function deleteCart($id)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)
            ->where('id', $id)
            ->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart item not found'], 404);
        }

        $cart->delete();

        // Calculate and update the total_amount of all products in the cart
        $carts = Cart::where('user_id', $user->id)->get();
        $couponDiscount = $cart->coupon_discount;
        $couponId = $cart->coupon_id;
        $totalAmount = $carts->sum('amount') - $couponDiscount;


        foreach ($carts as $cartItem) {
            $cartItem->total_amount = $totalAmount;
            $cartItem->coupon_discount = $couponDiscount;
            $cartItem->coupon_id = $couponId;
            $cartItem->save();
        }


        return response()->json(['success' => true, 'message' => 'Cart item deleted successfully'], 200);
    }



    //order
    public function order(Request $request)
    {
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->total = $request->total;
        $order->save();

        foreach ($request->products as $product) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $product['product_id'];
            $orderItem->quantity = $product['quantity'];
            $orderItem->amount = $product['amount'];
            $orderItem->save();
        }

        $carts = Cart::where('user_id', Auth::user()->id)->get();
        $couponApplied = false;

        foreach ($carts as $cart) {
            $cart->delete();

            // Check if a coupon was applied to the cart
            if ($cart->coupon_discount > 0) {
                $couponApplied = true;
                // Increment the used count of the coupon
                $coupon = Coupon::where('id', $cart->coupon_id)->first();
                $coupon->increment('used');
            }
        }

        // Create UserCoupon if a coupon was applied
        if ($couponApplied) {
            // $coupon = Coupon::where('code', $request->coupon_code)->first();
            $userCoupon = new UserCoupon();
            $userCoupon->user_id = Auth::user()->id;
            $userCoupon->coupon_id = $cart->coupon_id;
            $userCoupon->save();
        }

        return response()->json(['success' => true, 'message' => 'Your order has been placed'], 201);
    }

    //get order
    public function getOrder(Request $request)
    {
        try {
            $orders = Order::where('user_id', Auth::user()->id)->orderByDesc('created_at')->get();

            $processingOrder = $orders->where('status', 'processing')->count();
            $deliveredOrder = $orders->where('status', 'delivered')->count();
            $cancelledOrder = $orders->where('status', 'cancelled')->count();
            // return OrderResource::collection($orders);
            return response()->json([
                'processing_order' => $processingOrder,
                'delivered_order' => $deliveredOrder,
                'cancelled_order' => $cancelledOrder,
                'data' => OrderResource::collection($orders)
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while searching for orders'], 500);
        }
    }

    // Search products
    public function searchProducts(Request $request)
    {
        try {
            $keyword = $request->input('keyword');

            $products = Product::where('name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                ->get();

            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while searching for products'], 500);
        }
    }

    public function searchProductsByCommonAddress(Request $request)
    {
        try {
            $user = Auth::user();
            $common_address_id = $user->common_address_id;
            $keyword = $request->input('keyword');

            $products = Product::whereHas('vendor', function ($query) use ($common_address_id) {
                $query->where('common_address_id', $common_address_id);
            })
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('description', 'LIKE', '%' . $keyword . '%');
                })
                ->get();

            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while searching for products by common address'], 500);
        }
    }


    // Get hot products
    public function getHotProducts()
    {
        try {
            $products = Product::where('label', 'hot')->get();
            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving hot products'], 500);
        }
    }

    // Get hot products
    public function getNewProducts()
    {
        try {
            $products = Product::where('label', 'new')->get();
            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving new products'], 500);
        }
    }

    // Get hot products
    public function getSaleProducts()
    {
        try {
            $products = Product::where('label', 'sale')->get();
            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving sale products'], 500);
        }
    }

    // Get hot products by common address
    public function getHotProductsByCommonAddress()
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Get the common_address_id of the user
            $common_address_id = $user->common_address_id;

            // Retrieve hot products from vendors with common_address_id matching the user's common_address_id
            $products = Product::where('label', 'hot')
                ->whereHas('vendor', function ($query) use ($common_address_id) {
                    $query->where('common_address_id', $common_address_id);
                })
                ->get();

            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving hot products by common address'], 500);
        }
    }

    // Get sale products by common address
    public function getSaleProductsByCommonAddress()
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Get the common_address_id of the user
            $common_address_id = $user->common_address_id;

            // Retrieve sale products from vendors with common_address_id matching the user's common_address_id
            $products = Product::where('label', 'sale')
                ->whereHas('vendor', function ($query) use ($common_address_id) {
                    $query->where('common_address_id', $common_address_id);
                })
                ->get();

            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving sale products by common address'], 500);
        }
    }

    // Get new products by common address
    public function getNewProductsByCommonAddress()
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Get the common_address_id of the user
            $common_address_id = $user->common_address_id;

            // Retrieve new products from vendors with common_address_id matching the user's common_address_id
            $products = Product::where('label', 'new')
                ->whereHas('vendor', function ($query) use ($common_address_id) {
                    $query->where('common_address_id', $common_address_id);
                })
                ->get();

            return ProductResource::collection($products);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving new products by common address'], 500);
        }
    }
}
