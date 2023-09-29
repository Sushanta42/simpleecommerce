<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserMilestoneResource extends JsonResource
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
            "milestone_name" => $this->milestone->name,
            "plan_name" => $this->milestone->plan,
            "amount" => (float) $this->amount,
            "goal" => (float) $this->milestone->goal,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "status" => $this->status,
            "reward" => $this->reward,
            "destination" => $this->destination,
            "image" => asset($this->milestone->image),
        ];
    }
}
