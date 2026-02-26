<?php

namespace App\Models;

use App\Trait\HasQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasQuery;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'publish'
    ];
    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'categories_product', 'category_id', 'product_id')->withTimestamps();
    }
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    public $relationable = ['product'];
}
