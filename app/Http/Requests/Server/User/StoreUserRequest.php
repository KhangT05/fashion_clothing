<?php

namespace App\Http\Requests\Server\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
        'email' => 'required|email|unique:users,email,'.$this->id, // Kiểm tra trùng email (trừ id hiện tại khi update)
        'name' => 'required|string|max:255',
        'password' => $this->id ? 'nullable|min:6' : 'required|min:6', // Nếu sửa thì ko bắt buộc pass, thêm mới thì bắt buộc
        're_password' => 'same:password', // Nhập lại mật khẩu phải khớp
        'phone' => 'nullable|regex:/(0)[0-9]{9}/',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email này đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            're_password.same' => 'Mật khẩu nhập lại không khớp.',
        ];
    }
}