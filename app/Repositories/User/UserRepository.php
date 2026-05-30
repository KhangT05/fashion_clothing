<?php

namespace App\Repositories\User;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(
        User $model
    ) {
        $this->model = $model;
    }
    public function getUsers($filters = [])
    {
        $query = $this->model->orderBy('id', 'desc');

        if (!empty($filters['keyword'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['keyword'] . '%')
                    ->orWhere('phone', 'like', '%' . $filters['keyword'] . '%');
            });
        }

        if (isset($filters['publish']) && $filters['publish'] != -1) {
            $query->where('publish', $filters['publish']);
        }

        return $query->paginate(10);
    }
}
