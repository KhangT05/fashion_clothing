<?php

namespace App\Repositories;

use App\Models\BienThe;

class BienTheRepository extends BaseRepository
{
    public function __construct(BienThe $model)
    {
        $this->model = $model;
    }
}
