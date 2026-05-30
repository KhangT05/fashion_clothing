<?php

namespace App\Models;

use App\Trait\HasQuery;
use App\Trait\HasTransaction;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasTransaction, HasQuery;
    protected $table = 'slide';
    protected $fillable = [
        'tieude',
        'hinhthunho',
        'stt',
        'linklienket',
        'trangthai',
        'mota'
    ];
    public $relationable = [];
}
