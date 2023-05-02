<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommonAddress extends Model
{
    use HasFactory;

    /**
     * Get all of the vendors for the CommonAddress
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vendors()
    {
        return $this->hasMany(Vendor::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
