<?php

namespace App\Repositories;

use App\Models\LienHe;

class ContactRepository extends BaseRepository
{
    public function __construct(LienHe $model)
    {
        $this->model = $model;
    }

    public function filter(array $filter){
        return $this->model->where('trangthai',$filter['status'])
                           ->orderBy('created_at',$filter['sort'])
                           ->paginate(15);                      
    }


    public function updateContact($id){
        return LienHe::where('id', $id)->update([
            'trangthai' => 2
        ]);
    }
    public function destroyContact($id){
        return LienHe::where('id', $id)->update([
            'trangthai' => 0
        ]);
    }

}
