<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // Cast necessary fields to the appropriate data types
        $quantity = (int) $this->quantity;
        $rate = (float) $this->product->sale_price;
        $discount_percent = (float) $this->product->discount_percent;
        $mrp = (float) $this->product->price;
        $discount_amount = (float) - ($this->product->price - $this->product->sale_price);
        $amount = (float) $this->amount;
        $total_amount = (float) $this->total_amount;

        return [
            "id" => $this->id,
            "product_id" => $this->product->id,
            "product_title" => $this->product->name,
            "image" => asset($this->product->image),
            "quantity" => $quantity,
            "rate" => $rate,
            "discount_percent" => $discount_percent,
            "mrp" => $mrp,
            "discount_amount" => $discount_amount,
            "amount" => $amount,
            "total_amount" => $total_amount,
        ];
    }
}
