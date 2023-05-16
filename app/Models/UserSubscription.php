<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    use HasFactory;
    /**
     * Get the user that owns the UserSubscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the subscription that owns the UserSubscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function setRenewalDateAttribute($value)
    {
        if ($value < $this->end_date) {
            throw new \Exception("Renewal date cannot be before the end date.");
        }

        $this->attributes['renewal_date'] = $value;
    }
}
