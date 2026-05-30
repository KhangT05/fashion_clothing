<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SanphamVariant extends Model
{
    protected $table = 'sanpham_variants';
    public $relationable = ['attributesValues'];
    protected $fillable = [
        'sanpham_id',
        'sku',
        'hinhanh',
        'giaban',
        'soluong',
        'trangthai',
        'album'
    ];
    public function attributesValues(): BelongsToMany
    {
        return $this->belongsToMany(
            BientheValue::class,
            'variant_attribute_values',
            'variant_id',
            'bienthe_value_id'
        )->withTimestamps();
    }
    public function sanpham(): BelongsTo
    {
        return $this->belongsTo(Sanpham::class, 'sanpham_id');
    }
    protected $casts = [
        'album' => 'array'
    ];

    public function getPriceAttribute()
    {
        return $this->giaban ?? $this->sanpham->giaban ?? 0;
    }

    public function getDiscountedPriceAttribute()
    {
        $basePrice = $this->price;
        $discount = $this->sanpham->discount ?? 0;
        return $basePrice - ($basePrice * $discount / 100);
    }

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDiscountedPriceAttribute()
    {
        return number_format($this->discounted_price, 0, ',', '.');
    }
}
