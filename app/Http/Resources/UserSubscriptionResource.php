<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;


class UserSubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        // Calculate remaining days if the subscription is active
        $today = Carbon::today();
        $remainingDays = 0;
        if ($this->status === 'active' && $this->end_date) {
            $endDate = Carbon::parse($this->end_date);
            $remainingDays = $endDate->diffInDays($today, false); // false for not counting the end date itself
            // $endDate = Carbon::parse($this->end_date);
            // $remainingDays = $endDate->isFuture() ? $endDate->diffInDays() : 0;
        }
        $remainingDays = abs($remainingDays); // Remove the negative sign (if present)
        return [
            "id" => $this->id,
            "subscription_id" => $this->subscription->id,
            "plan_name" => $this->subscription->name,
            "price" => (float) $this->subscription->price,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "status" => $this->status,
            "paid" => (int) $this->paid,
            "remaining_days" => $remainingDays,
        ];
    }
}
