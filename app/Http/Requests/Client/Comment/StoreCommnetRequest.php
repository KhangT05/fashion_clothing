<?php

namespace App\Http\Requests\Client\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommnetRequest extends FormRequest
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
        return [
            'content' => 'required|string|max:500',
            'star' => 'required|integer|min:1|max:5',
        ];
    }
    public function messages()
    {
        return [
            'content.required' => 'Vui lòng nhập nội dung đánh giá',
            'content.max' => 'Nội dung không được quá 500 ký tự',
            'star.required' => 'Vui lòng chọn số sao đánh giá',
        ];
    }
}
