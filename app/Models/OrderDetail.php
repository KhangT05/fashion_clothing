<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'sku',
        'discount',
        'price',
        'order_id',
        'product_id',
        'total_amount',
        'quantity',
        'publish',
    ];

    // 1. Thuộc về Hóa đơn
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
    // 2. Thuộc về Sản phẩm (để lấy tên, ảnh sp hiển thị trong lịch sử đơn hàng)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function product_variant()
    {
        return $this->belongsTo(ProductVariant::class, 'sku', 'sku');
    }
    public $relationable = ['order'];
}
