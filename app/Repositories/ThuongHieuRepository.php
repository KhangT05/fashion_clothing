<?php

namespace App\Repositories;

use App\Models\ThuongHieu;

class ThuongHieuRepository extends BaseRepository
{
    public function __construct(ThuongHieu $model)
    {
        $this->model = $model;
    }
}
