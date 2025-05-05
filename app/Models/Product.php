<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // ✅ ESTA LÍNEA FALTABA

class Product extends Model
{
    protected $fillable = ["name", "description", "price", "image", "category_id"];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
