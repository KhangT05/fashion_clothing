<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeCategory extends Model
{
    protected $fillable = [
        'attribute_id',
        'value',
        'code',
        'publish'
    ];
    public function attribute(): BelongsTo
    {
        return $this->BelongsTo(Attributes::class, 'attribute_id');
    }
    public function attributeType(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'product_variant_id',
            'attribute_category_id',
            'variant_id'
        );
    }
    public $relationable = [];
}
