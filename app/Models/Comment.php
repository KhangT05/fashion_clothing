<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'content',
        'star', // Số sao đánh giá
        'publish'
    ];

    // 2. Liên kết ngược lại với bảng Sản phẩm để lấy tên/ảnh sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    // 3. Liên kết với User (nếu cần hiển thị tên người bình luận)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
