<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;

    // Khai báo đúng tên bảng trong database của bạn
    protected $table = 'provinces';

    // Khai báo các cột được phép thao tác (Dựa theo ảnh bạn gửi)
    protected $fillable = [
        'province_code', // Mã code (vd: 01)
        'name',          // Tên (vd: Thành phố Hà Nội)
        'short_name',
        'code',
        'place_type'
    ];

    // Mối quan hệ: Một tỉnh có nhiều xã (Thông qua province_code)
    // Lưu ý: Bảng wards của bạn đang dùng 'province_code' để liên kết chứ không phải 'province_id'
    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class, 'province_code', 'province_code');
    }
}
