<?php

namespace App\Http\Requests\Server\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            // Thông tin cơ bản sản phẩm
            'tensp' => 'required|string|min:4|max:255',
            'slug' => 'required|string|max:255|unique:sanpham,slug,' . $id,
            'giaban' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'hinhnen' => 'nullable|string',
            'trangthai' => 'nullable|integer|in:1,2',
            'thuonghieu_id' => 'nullable|exists:thuonghieu,id',
            // Categories (quan hệ nhiều-nhiều)
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            // Biến thể sản phẩm
            'sanpham_variants' => 'required_if:has_attribute,1|array|min:1',
            'sanpham_variants.*.sku' => 'nullable|string|max:50',
            'sanpham_variants.*.giaban' => 'nullable|numeric|min:0',
            'sanpham_variants.*.soluong' => 'required|integer|min:0',
            'sanpham_variants.*.attributes' => 'required|array|min:1',
            'sanpham_variants.*.trangthai' => 'nullable|integer|in:0,1',
            'sanpham_variants.*.album.*' => 'nullable|string',
        ];
    }
    public function messages(): array
    {
        return [
            'tensp.required' => 'Tên sản phẩm là bắt buộc',
            'tensp.min' => 'Tên sản phẩm phải có ít nhất 4 ký tự',
            'giaban.required' => 'Giá bán là bắt buộc',
            'giaban.numeric' => 'Giá bán phải là số',
            'slug.required' => 'Slug không được để trống',
            'categories.required' => 'Phải chọn ít nhất 1 danh mục',
            'sanpham_variants.required_if' => 'Phải có ít nhất 1 biến thể khi bật tính năng biến thể',
            'sanpham_variants.*.soluong.required_with' => 'Số lượng biến thể là bắt buộc',
            'sanpham_variants.*.attributes.required_with' => 'Thuộc tính biến thể là bắt buộc',
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->tensp),
            'has_attribute' => $this->has_attribute ? 1 : 0,
        ]);
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->has_attribute == 1 && $this->filled('sanpham_variants')) {
                $this->validateVariantCombinations($validator);
                $this->validateSkuDuplicates($validator);
            }
        });
    }
    private function validateVariantCombinations($validator)
    {
        $combinations = [];

        foreach ($this->sanpham_variants ?? [] as $index => $variant) {
            if (!isset($variant['attributes']) || !is_array($variant['attributes'])) {
                continue;
            }
            $sortedAttributes = $variant['attributes'];
            sort($sortedAttributes);
            $combination = implode('-', $sortedAttributes);
            if (in_array($combination, $combinations)) {
                $validator->errors()->add(
                    "sanpham_variants.{$index}.attributes",
                    'Tổ hợp thuộc tính này đã tồn tại. Mỗi biến thể phải có tổ hợp thuộc tính duy nhất.'
                );
            }

            $combinations[] = $combination;
        }
    }
    private function validateSkuDuplicates($validator)
    {
        $productId = $this->route('id');
        foreach ($this->sanpham_variants ?? [] as $index => $variant) {
            if (!isset($variant['sku'])) {
                continue;
            }
            $query = DB::table('sanpham_variants')
                ->where('sku', $variant['sku']);
            if ($productId) {
                $query->where('sanpham_id', '!=', $productId);
            }
            if (isset($variant['id'])) {
                $query->where('id', '!=', $variant['id']);
            }
            $existingSku = $query->exists();
            if ($existingSku) {
                $validator->errors()->add(
                    "sanpham_variants.{$index}.sku",
                    "SKU '{$variant['sku']}' đã tồn tại trong hệ thống"
                );
            }
        }
    }
}
