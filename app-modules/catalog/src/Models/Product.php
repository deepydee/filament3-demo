<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Catalog\Enums\ProductStatus;
use Modules\Catalog\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'status',
        'category_id',
    ];

    protected $casts = [
        'status' => ProductStatus::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
