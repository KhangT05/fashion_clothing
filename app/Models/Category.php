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
    public function products()
    {
        // Giả sử model sản phẩm là Product hoặc Sanpham
        return $this->hasMany(Sanpham::class, 'category_id', 'id');
    }
    public function scopeActive($query)
    {
        return $query->where('publish', 1);
    }
    public function scopeHome($query)
    {
        return $query->where('is_home', 1);
    }
    public function sanpham(): BelongsToMany
    {
        return $this->belongsToMany(Sanpham::class, 'categories_sanpham', 'category_id', 'sanpham_id')->withTimestamps();
    }
    public function getRouteKeyName(): string
    {
        return 'slug';
    }
    public $relationable = ['sanpham'];
}
