<?php

namespace App\Services;

use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserService extends BaseService
{
    protected $repository;
    protected $sort = ['id', 'asc'];
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    protected function prepageModeldata(Request $request): self
    {
        return $this;
    }
    public function paginate($request)
    {
        $filters = $request->all();
        return $this->repository->getUsers($filters);
    }
    public function show($column, $value)
    {
        // SỬA: Gọi 'findByField' thay vì 'findBy'
        return $this->repository->findByField($column, $value);
    }

    public function create(Request $request)
    {
        try {
            $this->beginTransaction();
            $payload = $request->except(['_token', 'send']);
            $payload['password'] = Hash::make($payload['password']); // Mã hóa pass
            $user = $this->repository->create($payload);
            $this->commit();
            return $user;
        } catch (\Exception $e) {
            $this->rollBack();
            return false;
        }
    }
    // public function update($id, $request)
    // {
    //     DB::beginTransaction();
    //     try {
    //         $payload = $request->except(['_token', 'send']);

    //         // Nếu không nhập pass mới thì bỏ qua, giữ pass cũ
    //         if (empty($payload['password'])) {
    //             unset($payload['password']);
    //         } else {
    //             $payload['password'] = Hash::make($payload['password']);
    //         }

    //         $this->repository->update($id, $payload);
    //         DB::commit();
    //         return true;
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return false;
    //     }
    // }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            // THAY ĐỔI Ở ĐÂY:
            // Thay vì xóa cứng: $this->repository->delete($id);
            // Chúng ta cập nhật trạng thái publish về 0 (0 nghĩa là đã xóa/khóa)
            $payload = [
                'publish' => 0,
            ];

            $this->repository->update($id, $payload);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log lỗi nếu cần: Log::error($e->getMessage());
            return false;
        }
    }

    public function restore($id)
    {
        DB::beginTransaction();
        try {
            // Cập nhật publish = 1 (Hoạt động lại)
            $this->repository->update($id, ['publish' => 1]);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
