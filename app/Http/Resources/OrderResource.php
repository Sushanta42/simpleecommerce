<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "total" => (int) $this->total,
            "status" => $this->status,
            "delivered_time" => $this->delivered_time,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
