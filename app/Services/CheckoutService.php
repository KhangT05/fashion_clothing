<?php

namespace App\Services;

use App\Services\BaseService;
use App\Repositories\OrderRepository;

use Illuminate\Http\Request;

class CheckoutService extends BaseService
{
    protected $repository;
    public function __construct(
        OrderRepository $repository,
    ) {
        $this->repository = $repository;
    }
    protected function perpageModelData(Request $request): self
    {
        return $this->initialBasicData($request);
    }
    public function initialBasicData(Request $request)
    {
        $fillable = $this->repository->getFillable();
        $payload = $request->only($fillable);
        if ($request->has('checkout')) {
            $checkout = $request->input('checkout');
            $payload['total_amount'] = $checkout['finalPrice'] ?? $checkout['totalPrice'] ?? 0;
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
                'name' => $ct_hoadonData['name'],
                'price' => $ct_hoadonData['gia_goc'],
                'quantity' => $ct_hoadonData['so_luong'],
                'discount' => $ct_hoadonData['discount'] ?? 0,
                'total_amount' => $ct_hoadonData['thanh_tien'],
                'publish' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
