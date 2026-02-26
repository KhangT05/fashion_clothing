<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Trait\HasQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory, HasQuery;

    protected $fillable = [
        'user_id',
        'sku',
        'quantity',
        'price',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function product_variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'sku', 'sku');
    }
    public $relationable = ['user', 'product_variant'];
}
