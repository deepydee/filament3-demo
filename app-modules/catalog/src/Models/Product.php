<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Enums\ProductStatus;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'status',
    ];

    protected $casts = [
        'status' => ProductStatus::class,
    ];
}
