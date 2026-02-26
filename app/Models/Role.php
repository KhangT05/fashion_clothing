<?php

namespace App\Models;

use App\Trait\HasQuery;
use App\Trait\HasTransaction;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasQuery, HasTransaction;
    protected $fillable = [
        'name',
        'description',
        'publish'
    ];
    public $relationable = [];
}
