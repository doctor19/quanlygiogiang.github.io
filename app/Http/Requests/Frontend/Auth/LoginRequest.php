<?php

namespace App\Http\Requests\Frontend\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập địa chỉ email',
            'email.email'  => 'Định dạng email không chính xác',
            'email.exists' => 'Email hoặc mật khẩu không chính xác',
            'password.required'  => 'Vui lòng nhập mật khẩu'
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => ['required', 'email','exists:users,email,active,1'],
            'password' => 'required'
        ];
    }
}
