<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    /**
     * Get the sub_category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
