<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            "price" => (float) $this->price,
            "duration" => (int) $this->duration,
            "type" => $this->type,
            "plan" => $this->plan,
            "active" => (int) $this->active,
        ];
    }
}
