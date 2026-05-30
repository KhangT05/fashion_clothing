<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;
class ContactService extends BaseService
{

    protected $repository;
    protected array $payload = [];
    protected function prepageModeldata(Request $request):self
    {
        $this->payload = $request->only([
            'name',
            'email',
            'noidung',
            'trangthai' =>1,
        ]);

        return $this;
    }
    public function __construct(
        ContactRepository $repository
    ) {
        $this->repository = $repository;
    }
    public function filterContact(array $filer){
        return $this->repository->filter($filer);
    }
    public function sendContact(Request $request){
        $this->prepageModeldata($request);
        return $this->repository->create($this->payload);
    }

    public function updateContact($id){
        return $this->repository->updateContact($id);
    }

    public function destroyContact($id){
        return $this->repository->destroyContact($id);
    }
}