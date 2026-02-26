<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ward extends Model
{
    protected $table = 'wards';
    protected $fillable = [
        'ward_code',
        'name',
        'province_code' // Cột này dùng để nối với bảng provinces
    ];
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_code', 'province_code');
    }
    public $relationable = [];
}
