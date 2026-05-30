<?php

namespace App\Models;

use App\Trait\HasQuery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sanpham extends Model
{
    use HasFactory, HasQuery;

    protected $table = 'sanpham';

    protected $fillable = [
        'id',
        'tensp',
        'hinhnen',
        'giaban',
        'discount',
        'slug',
        'mota',
        'has_attribute',
        'thuonghieu_id',
        'trangthai',
        'deleted_at'
    ];

    // Nếu bạn muốn truy ngược lại xem sản phẩm này nằm trong đơn hàng nào (ít dùng nhưng có thể cần thống kê)


    public function usersYeuthich()
    {
        return $this->belongsToMany(User::class, 'yeuthich', 'sanpham_id', 'user_id');
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'categories_sanpham', 'sanpham_id', 'category_id')->withTimestamps();
    }
    public function thuonghieu(): BelongsTo
    {
        return $this->belongsTo(ThuongHieu::class);
    }
    // Format giá bán
    // public function getFormatPrice()
    // {
    //     return number_format($this->giaban, 0, ',', '.') . ' d';
    // }

    //Thêm khóa ngoại cho giỏ hàng
    public function cart()
    {
        return $this->hasMany(Giohang::class, 'sanpham_id', 'id');
    }
    // 1-n 1 sản phẩm chứa nhiều variants
    public function sanpham_variants(): HasMany
    {
        return $this->hasMany(SanphamVariant::class, 'sanpham_id', 'id');
    }
    public $relationable = ['categories'];
    public function binhluan(): HasMany
    {
        return $this->HasMany(Binhluan::class, 'sanpham_id', 'id');
    }
}
