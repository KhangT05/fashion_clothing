<?php

namespace App\Http\Requests\Server\Slide;

use Illuminate\Foundation\Http\FormRequest;

class StoreSlideRequest extends FormRequest
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
            'tieude' => 'required|string|max:255',
            'hinhthunho' => 'nullable|string|max:500',
            'stt' => 'nullable|integer|min:0',
            'linklienket' => 'nullable|max:500',
            'trangthai' => 'required|in:0,1',
            'mota' => 'nullable|string|max:2000',
        ];
    }
    public function messages(): array
    {
        return [
            'tieude.required' => 'Vui lòng nhập tên slide',
            'trangthai.required' => 'Vui lòng chọn trạng thái',
        ];
    }
}
