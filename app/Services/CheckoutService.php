<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\Order\OrderRepository;

use Illuminate\Http\Request;

class CheckoutService extends BaseService
{
    protected $repository;
    public function __construct(
        OrderRepository $repository,
    ) {
        $this->repository = $repository;
    }
    protected function prepageModeldata(Request $request): self
    {
        $fillable = $this->repository->getFillable();
        $payload = $request->only($fillable);
        if ($request->has('checkout')) {
            $checkout = $request->input('checkout');
            $payload['thanhtien'] = $checkout['finalPrice'] ?? $checkout['totalPrice'] ?? 0;
        }
        $this->modelData = $payload;
        return $this;
    }
    public function handleRelation(Request $request): self
    {
        $relations = $this->repository->getRelationable();
        if (count($relations)) {
            foreach ($relations as $key => $relation) {
                // nếu có belongs to many thì xử lý tự động thêm sync có trong laravel
                if ($request->has($relation)) {
                    // {} là gọi dữ liệu động method quan hệ
                    $this->model->{$relation}()->sync($request->$relation);
                }
            }
        }

        $this->handleOrderDetails($request);
        return $this;
    }
    private function handleOrderDetails(Request $request)
    {
        if (!$request->has('checkout')) {
            return $this;
        }
        $checkout = $request->input('checkout');
        foreach ($checkout['items'] as $ct_hoadonData) {
            $ct_hoadon = $this->model->chiTiet()->create([
                ...$ct_hoadonData,
                'sanpham_id' => $ct_hoadonData['product_id'],
                'sku' => $ct_hoadonData['sku'] ?? '',
                'name' => $ct_hoadonData['ten'],
                'dongia' => $ct_hoadonData['gia_goc'],
                'soluong' => $ct_hoadonData['so_luong'],
                'discount' => $ct_hoadonData['discount'] ?? 0,
                'thanhtien' => $ct_hoadonData['thanh_tien'],
                'trangthai' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
