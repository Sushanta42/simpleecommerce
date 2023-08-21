<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "code" => $this->code,
            "discount_amount" => $this->discount_amount,
            "max_uses" => $this->max_uses,
            "used" => $this->used,
            "valid_from" => $this->valid_from,
            "valid_to" => $this->valid_to,
            "user_id" => $this->user_id,
            "status" => $this->status,
        ];
    }
}
