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

        // Initialize counters for media types
        $imageIndex = 1;
        $videoIndex = 1;

        // Initialize an empty array for media
        $mediaArray = [];

        // Iterate over each media item and add it to the media array
        foreach ($this->media as $media) {
            if ($media->media_type === 'image') {
                $key = "media_image" . $imageIndex;
                $imageIndex++;
            } elseif ($media->media_type === 'video') {
                $key = "media_video" . $videoIndex;
                $videoIndex++;
            } else {
                continue; // Skip if media type is neither image nor video
            }
            $mediaArray[$key] = asset($media->file_path);
        }   

        return array_merge([
            "id" => $this->id,
            "name" => $this->name,
            "description" => $this->description,
            "sub_category_id" => $this->sub_category->name ?? 'Null',
            "image" => asset($this->image),
            "price" => $price,
            "discount_percent" => $discountPercent,
            "discount_amount" => - ($this->price - $this->sale_price),
            "sale_price" => $salePrice,
            "availability" => $this->availability,
            "label" => $this->label,
            "vendor_id" => (int) $this->vendor_id,
        ], $mediaArray);
    }
}
