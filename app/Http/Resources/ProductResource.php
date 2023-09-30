<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // Convert the price, discount_percent, and sale_price to numbers
        $price = (float)$this->price;
        $discountPercent = (float)$this->discount_percent;
        $salePrice = (float)$this->sale_price;

        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "sub_category_id" => $this->sub_category->name,
            "image" => asset($this->image),
            "price" => $price,
            "discount_percent" => $discountPercent,
            "discount_amount" => - ($this->price - $this->sale_price),
            "sale_price" => $salePrice,
            "availability" => $this->availability,
            "label" => $this->label,
            "vendor_id" => (int) $this->vendor_id,
        ];
    }
}
