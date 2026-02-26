<?php

namespace App\Repositories;

use App\Models\BinhLuan;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository
{
    public function __construct(
        BinhLuan $model
    ) {
        $this->model = $model;
    }
}
