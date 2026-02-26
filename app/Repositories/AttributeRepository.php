<?php

namespace App\Repositories;

use App\Models\Attributes;

class AttributeRepository extends BaseRepository
{
    public function __construct(Attributes $model)
    {
        $this->model = $model;
    }
}
