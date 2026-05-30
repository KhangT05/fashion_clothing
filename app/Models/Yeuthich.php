<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yeuthich extends Model
{
    use HasFactory;

    protected $table = 'yeuthich';

    protected $fillable = [
        'user_id',
        'sanpham_id',
        'ngaythem',
    ];

    public function sanpham()
    {
        return $this->belongsTo(Sanpham::class, 'sanpham_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}