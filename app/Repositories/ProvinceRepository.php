<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;

class ProvinceRepository extends BaseRepository
{
    protected $model;
    public function __construct(Province $model)
    {
        $this->model = $model;
    }
}
