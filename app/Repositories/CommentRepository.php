<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\BaseRepository;

class CommentRepository extends BaseRepository
{
    public function __construct(
        Comment $model
    ) {
        $this->model = $model;
    }
}
