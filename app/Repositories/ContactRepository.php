<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository extends BaseRepository
{
    public function __construct(Contact $model)
    {
        $this->model = $model;
    }
}
