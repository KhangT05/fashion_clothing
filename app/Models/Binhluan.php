<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binhluan extends Model
{
    use HasFactory;

    // 1. Khai báo tên bảng trong Database (Sửa lại nếu bảng của bạn tên khác, v.d: 'danhgia', 'comments')
    protected $table = 'binhluan';

    protected $fillable = [
        'user_id',
        'sanpham_id',
        'noidung',
        'danhgia', // Số sao đánh giá
        'trangthai'
    ];

    // 2. Liên kết ngược lại với bảng Sản phẩm để lấy tên/ảnh sản phẩm
    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'sanpham_id', 'id');
    }

    // 3. Liên kết với User (nếu cần hiển thị tên người bình luận)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
