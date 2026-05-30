<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThuongHieu extends Model
{
    protected $table = 'thuonghieu';
    protected $fillable = [
        'tenth',
        'logo',
        'slug',
        'mota',
        'trangthai'
    ];
    public function sanpham(): HasMany
    {
        return $this->hasMany(Sanpham::class);
    }
}
