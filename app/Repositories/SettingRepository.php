<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class SettingRepository extends BaseRepository
{
    public function __construct(
        Setting $model
    ) {
        $this->model = $model;
    }
}
