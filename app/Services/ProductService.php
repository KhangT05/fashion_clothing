<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\Services\BaseService;
use Illuminate\Http\Request;

class ProductService extends BaseService
{
    protected $repository;
    protected $filterSearch = ['name'];
    protected $relationFilter = [
        'categories' => 'category_id',
        'has_attribute' => 1,
    ];
    protected $complexFilter = [
        ['product_variant.price', '>=', 'min_price'],
        ['product_variant.price', '<=', 'max_price'],
    ];
    protected $with = ['categories', 'brand', 'product_variant'];
    public function __construct(
        ProductRepository $repository
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
    public function handleRelation(Request $request): self
    {
        // dd($request);
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
        $this->handleProductVariants($request);
        return $this;
    }
    private function handleProductVariants(Request $request)
    {
        if (!$request->has('product_variant') || !is_array($request->input('product_variant'))) {
            return $this;
        };
        if (!$request->has_attribute || $request->has_attribute == 0) {
            // Tắt variants - xóa tất cả variants cũ
            $this->model->product_variant()->each(function ($variant) {
                $variant->attributesValues()->detach();
                $variant->delete();
            });
            return $this;
        }
        $existingVariantIds = $this->model->product_variant()->pluck('id')->toArray();
        $submittedVariantIds = [];
        $variantsData = $request->input('product_variant');
        $commonAlbum = $request->has('album') ? $request->input('album') : [];
        if (!is_array($variantsData) || empty($variantsData)) {
            $this->model->product_variant()->each(function ($variants) {
                $variants->attributesValues()->detach();
                $variants->delete();
            });
            return $this;
        };
        foreach ($variantsData as $variantData) {
            if (
                !isset($variantData['sku']) ||
                !isset($variantData['price']) ||
                !isset($variantData['quantity']) ||
                !isset($variantData['attributes'])
            ) {
                continue;
            }
            $albumData = [];
            if (isset($variantData['album']) && is_array($variantData['album']) && !empty($variantData['album'])) {
                $albumData = $variantData['album'];
            } elseif (!empty($commonAlbum)) {
                $albumData = $commonAlbum;
            }
            $variantPayload = [
                'sku' => $variantData['sku'],
                'price' => $this->clearPrice($variantData['price']),
                'quantity' => (int)($variantData['quantity'] ?? 0),
                'album' => $albumData,
                'publish' => $request->publish ?? 1,
            ];
            if (isset($variantData['id']) && !empty($variantData['id'])) {
                $variant = $this->model->product_variant()->find($variantData['id']);
                if ($variant) {
                    $variant->update($variantPayload);
                    if (isset($variantData['attributes']) && is_array($variantData['attributes'])) {
                        $variant->attributesValues()->sync($variantData['attributes']);
                    }
                    $submittedVariantIds[] = $variant->id;
                }
            } else {
                $variant = $this->model->product_variant()->create($variantPayload);
                // Xử lý attributes - attach từng cặp type_id và value_id
                if (isset($variantData['attributes']) && is_array($variantData['attributes'])) {
                    $variant->attributesValues()->attach($variantData['attributes']);
                }
                $submittedVariantIds[] = $variant->id;
            }
        }
        // DELETE các variants không còn tồn tại
        $variantsToDelete = array_diff($existingVariantIds, $submittedVariantIds);
        if (!empty($variantsToDelete)) {
            foreach ($variantsToDelete as $deleteId) {
                $variantToDelete = $this->model->product_variant()->find($deleteId);
                if ($variantToDelete) {
                    $variantToDelete->attributesValues()->detach();
                    $variantToDelete->delete();
                }
            }
        }
        $this->updateTotalQuantity();
        return $this;
    }
    private function updateTotalQuantity()
    {
        $totalQuantity = $this->model->product_variant()->sum('quantity');
        $this->model->update(['quantity' => $totalQuantity]);
    }
    private function clearPrice($price)
    {
        if (empty($price)) {
            return 0;
        }

        // Loại bỏ khoảng trắng
        $price = trim($price);

        // Xử lý theo định dạng Việt Nam: 1.000.000 hoặc 1,000,000
        // Giữ lại dấu chấm/phẩy cuối cùng làm phân cách thập phân

        // Đếm số dấu chấm và phẩy
        $dotCount = substr_count($price, '.');
        $commaCount = substr_count($price, ',');

        // Nếu có nhiều dấu chấm -> định dạng VN (1.000.000)
        if ($dotCount > 1) {
            $price = str_replace('.', '', $price); // Xóa dấu chấm phân cách hàng nghìn
            $price = str_replace(',', '.', $price); // Chuyển dấu phẩy thành dấu chấm thập phân
        }
        // Nếu có nhiều dấu phẩy -> định dạng US (1,000,000)
        elseif ($commaCount > 1) {
            $price = str_replace(',', '', $price); // Xóa dấu phẩy phân cách hàng nghìn
        }
        // Nếu có cả chấm và phẩy -> xác định cái nào là thập phân
        elseif ($dotCount > 0 && $commaCount > 0) {
            // Cái nào xuất hiện sau là dấu thập phân
            $lastDot = strrpos($price, '.');
            $lastComma = strrpos($price, ',');

            if ($lastDot > $lastComma) {
                // Dấu chấm là thập phân (1,000.50)
                $price = str_replace(',', '', $price);
            } else {
                // Dấu phẩy là thập phân (1.000,50)
                $price = str_replace('.', '', $price);
                $price = str_replace(',', '.', $price);
            }
        }
        // Chỉ có 1 dấu phẩy -> có thể là thập phân VN (100,50) hoặc hàng nghìn (1,000)
        elseif ($commaCount == 1) {
            // Nếu sau dấu phẩy có 3 chữ số -> đó là hàng nghìn
            if (preg_match('/,\d{3}$/', $price)) {
                $price = str_replace(',', '', $price);
            } else {
                // Ngược lại là thập phân
                $price = str_replace(',', '.', $price);
            }
        }
        // Chuyển thành float
        return (float) $price;
    }
}
