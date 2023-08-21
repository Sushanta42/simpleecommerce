<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasFactory;
    /**
     * The userMilestones that belong to the Milestone
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userMilestones()
    {
        return $this->belongsToMany(UserMilestone::class);
    }
}
