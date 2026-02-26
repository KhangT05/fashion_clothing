<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Trait\HasQuery;

class Product extends Model
{
    use HasFactory, HasQuery;

    protected $fillable = [
        'id',
        'name',
        'image',
        'price',
        'discount',
        'slug',
        'description',
        'has_attribute',
        'brand_id',
        'publish',
        'deleted_at'
    ];
    public function wishlist()
    {
        // Quan hệ Nhiều - Nhiều với bảng Sanpham thông qua bảng trung gian 'yeuthich'
        return $this->belongsToMany(User::class, 'wishlist', 'product_id', 'user_id')
            ->withTimestamps();
    }
    // Nếu bạn muốn truy ngược lại xem sản phẩm này nằm trong đơn hàng nào (ít dùng nhưng có thể cần thống kê)
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'categories_products', 'product_id', 'category_id')->withTimestamps();
    }
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    //Thêm khóa ngoại cho giỏ hàng
    public function cart()
    {
        return $this->hasMany(Cart::class, 'product_id', 'id');
    }
    // 1-n 1 sản phẩm chứa nhiều variants
    public function product_variant(): HasMany
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }
    public $relationable = ['categories'];
    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }
}
