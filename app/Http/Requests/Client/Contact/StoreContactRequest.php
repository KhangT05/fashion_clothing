<?php

namespace App\Http\Requests\Client\Contact;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreContactRequest extends FormRequest
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
            'name' => 'required|string|min:4|max:100',
            'email' => 'required|email',
            'noidung' => 'required|max:300',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
            'email.required'=> 'Vui lòng nhập email.',
            'noidung.required'=> 'Vui lòng nhập nội dung',
            'noidung.max' => 'Nội dung không vượt quá 300 ký tự'
        ];
    }
}
