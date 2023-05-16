<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CategoryUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $common_address_id = Auth::user()->common_address_id;

        return [
            "id" => $this->id,
            "name" => $this->name,
            "slug" => $this->slug,
            "image" => asset($this->image),
            "products" => ProductResource::collection(
                $this->products->filter(function ($product) use ($common_address_id) {
                    return $product->vendor->common_address_id == $common_address_id;
                })
            ),
            "subcategories" => SubCategoryResource::collection($this->subcategories)
        ];
    }
}
