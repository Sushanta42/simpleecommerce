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
        return [
            "id" => $this->id,
            "product_id" => $this->product->id,
            "product_title" => $this->product->name,
            "image" => asset($this->product->image),
            "quantity" => $this->quantity,
            "rate" => $this->product->sale_price,
            "discount_percent" => $this->product->discount_percent,
            "mrp" => $this->product->price,
            "discount_amount" => -($this->product->price - $this->product->sale_price),
            "amount" => $this->amount,
        ];
    }
}
