<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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

            return response()->json(['success' => true, 'message' => 'Quantity updated in cart successfully'], 200);
        }

        // Create a new cart entry if the product doesn't exist in the cart
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->product_id = $productId;
        $cart->quantity = $quantity;
        $cart->amount = $quantity * $request->price;
        $cart->save();

        return response()->json(['success' => true, 'message' => 'Item added to cart successfully'], 201);
    }


    //get cart
    public function getCart()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();
        return CartResource::collection($carts);
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
        foreach ($carts as $cart) {
            $cart->delete();
        }

        return response()->json(['success' => true, 'message' => 'Your order has been placed'], 201);
    }
}
