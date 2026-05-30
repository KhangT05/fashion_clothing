<?php

namespace App\Repositories;

use App\Models\Hoadon;

class OrderRepository extends BaseRepository
{
    public function __construct(Hoadon $model)
    {
        $this->model = $model;
    }
}
