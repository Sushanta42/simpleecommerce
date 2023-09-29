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
            "discount_amount" => (int) $this->discount_amount,
            "max_uses" => (int) $this->max_uses,
            "used" => (int) $this->used,
            "valid_from" => $this->valid_from,
            "valid_to" => $this->valid_to,
            "user_id" => $this->user_id !== null ? (int)$this->user_id : null,
            "status" => $this->status,
        ];
    }
}
