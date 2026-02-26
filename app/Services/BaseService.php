<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Trait\HasTransaction;
use Illuminate\Http\Request;

abstract class BaseService
{
    use HasTransaction;
    protected $repository;
    protected $resutl;
    protected $modelData;
    protected $model;
    protected $type;
    protected $perpage = 20;
    protected $sort = ['id', 'asc'];
    protected $with = [];
    protected $filterSearch = ['name'];
    protected $simpleFilter = ['publish'];
    protected $complexFilter = ['price'];
    abstract protected function perpageModelData(Request $request): self;
    public function __construct(
        Baserepository $repository
    ) {
        $this->repository = $repository;
    }
    private function buildFilter(Request $request, array $filter = []): array
    {
        $condition = [];
        if (count($filter)) {
            foreach ($filter as $key => $val) {
                if ($request->has($val)) {
                    $condition[$val] = $request[$val];
                }
            }
        }
        return $condition;
    }
    public function specifications(Request $request): array
    {
        return [
            'type' => $request->type === 'all' ?? $this->type,
            'perpage' => $request->perpage ?? $this->perpage,
            'sort' => $request->sort ? explode(',', $request->sort) : $this->sort,
            'with' => $this->with,
            'keyword' => [
                'q' => $request->keyword,
                'fields' => $this->filterSearch,
            ],
            'filter' => [
                'simple' => $this->buildFilter($request, $this->simpleFilter),
                'complex' => $this->buildFilter($request, $this->complexFilter)
            ],
        ];
    }
    public function pagination(Request $request)
    {
        $specs = $this->specifications($request);
        return $this->repository->pagination($specs);
    }
    public function index()
    {
        return $this->repository->index();
    }
    // mục đích khi tạo ra hàm này là để bắt buộc các class con phải khai báo dữ liệu
    // , chuẩn bị cho việc thêm hoặc cập nhật dữ liệu
    public function save(Request $request, ?int $id = null)
    {
        try {
            return $this
                ->beginTransaction()
                ->perpageModelData($request)
                ->beforeSave()
                ->saveModel($id)
                ->afterSave()
                ->handleRelation($request)
                ->commit();
        } catch (\Throwable $th) {
            $this->rollBack();
            throw $th;
        }
    }
    // public function attach()
    // {
    //     return $this->repository->attach();
    // }
    // public function detach()
    // {
    //     return $this->repository->detach();
    // }
    public function show(string $field, $value)
    {
        return $this->repository->findByField($field, $value);
    }
    // xóa vĩnh viễn
    public function trash($id)
    {
        try {
            $this->beginTransaction();
            $model = $this->repository->trash($id);
            $this->commit();
            return $model;
        } catch (\Throwable $th) {
            $this->rollBack();
            throw $th;
        }
    }
    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }
    public function convertToJsonArray($data)
    {
        if (is_array($data)) {
            return array_values(array_filter($data));
        }
        if (is_string($data)) {
            //chuyển json string sang array
            $decoded = json_decode($data, true);
            return is_array($decoded) ? array_values(array_filter($decoded)) : [];
        }
    }
    //xóa mêm
    public function delete($id)
    {
        try {
            return $this
                ->beginTransaction()
                ->beforeDelete($id)
                ->performDelete($id)
                ->afterDelete($id)
                ->commit();
        } catch (\Throwable $th) {
            $this->rollBack();
            throw $th;
        }
    }
    // khôi phục
    public function restore($id)
    {
        try {
            return $this
                ->beginTransaction()
                ->beforeRestore($id)
                ->performRestore($id)
                ->afterRestore($id)
                ->commit();
        } catch (\Throwable $th) {
            $this->rollBack();
            throw $th;
        }
    }
}
