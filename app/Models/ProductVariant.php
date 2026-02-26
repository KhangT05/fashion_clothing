<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductVariant extends Model
{
    public $relationable = ['product_variant_attribute'];
    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'quantity',
        'publish',
        'album'
    ];
    public function product_variant_attribute(): BelongsToMany
    {
        return $this->belongsToMany(
            AttributeCategory::class,
            'variant_attribute_values',
            'product_variant_id',
            'attribute_category_id'
        )->withTimestamps();
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    protected $casts = [
        'album' => 'array'
    ];
}
