<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\CartRepository;
use App\Services\BaseService;

class CartService extends BaseService
{
    protected $repository;
    protected $with = ['product_variant'];

    public function __construct(
        CartRepository $repository
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
        $this->modelData = $payload;
        return $this;
    }
    public function updateQuantity(int $cartId, string $type)
    {
        $cart = $this->repository->findById($cartId);
        if (!$cart) {
            return false;
        }
        if ($type === 'increase') {
            $cart->soluong++;
        } else {
            $cart->soluong--;

            if ($cart->soluong <= 0) {
                return $cart->delete();
            }
        }
        return $cart->save();
    }
}
