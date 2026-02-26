<?php

namespace App\Models;

use App\Trait\HasQuery;
use App\Trait\HasTransaction;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasTransaction, HasQuery;
    protected $fillable = [
        'name',
        'address',
        'description',
        'logo',
        'facebook_url',
        'youtube_url',
        'instagram_url',
        'linkedin_url',
        'copyright',
        'sales_info',
        'sales_services',
        'shipping_policy',
        'about_us',
        'return_policy',
        'warranty_policy',
        'privacy_policy',
        'publish',
    ];
    public $relationable = [];
}
