<?php

namespace Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SolutionForest\FilamentTree\Concern\ModelTree;

class Category extends Model
{
    use HasFactory;
    use ModelTree;

    protected $fillable = [
        'name',
        'parent_id',
        'order',
    ];

    protected $table = 'categories';

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function determineTitleColumnName(): string
    {
        return 'name';
    }
}
