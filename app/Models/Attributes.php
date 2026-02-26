<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attributes extends Model
{
    protected $fillable = [
        'type',
        'publish'
    ];
    public function attribute_category(): HasMany
    {
        return $this->hasMany(AttributeCategory::class, 'attribute_id');
    }
    public $relationable = [];
}
