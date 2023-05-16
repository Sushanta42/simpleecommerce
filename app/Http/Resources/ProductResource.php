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
        return [
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "sub_category_id" => $this->sub_category->name,
            "image" => asset($this->image),
            "price" => $this->price,
            "discount_percent" => $this->discount_percent,
            "discount_amount" => -($this->price - $this->sale_price),
            "sale_price" => $this->sale_price,
            "availability" => $this->availability,
            "label" => $this->label,
            "vendor_id" => $this->vendor_id,
        ];
    }
}
