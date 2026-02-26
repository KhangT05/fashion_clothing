<?php

namespace App\Http\Requests\Server\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateCategoryRequest extends FormRequest
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
            'name' => 'required|string|min:4|max:100|unique:categories,name,' . $id,
            'slug' => 'required|string',
            'publish' => 'integer|gte:1|lte:2',
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->name)
        ]);
    }
    public function messages()
    {
        return [
            'name.unique' => 'Danh mục này đã tồn tại.',
        ];
    }
}
