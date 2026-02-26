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
        'title',
        'thumbnail',
        'order',
        'link_url',
        'publish',
        'description'
    ];
    public $relationable = [];
}
