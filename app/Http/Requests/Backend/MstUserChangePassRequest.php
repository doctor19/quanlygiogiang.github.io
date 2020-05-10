<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MstUserChangePassRequest extends FormRequest
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
        $messages = [];
        $messages['password_old.required']  = 'Vui lòng nhập mật khẩu cũ';
        $messages['password.required']  = 'Vui lòng nhập mật khẩu';
        $messages['password.min']  = 'Mật khẩu phải lớn hơn 6 kí tự';
        $messages['password.confirmed']   = 'Mật khẩu không khớp nhau';
        $messages['password_confirmation.min']  = 'Xác nhận mật khẩu phải lớn hơn 6 kí tự';
        $messages['password_confirmation.required']   = 'Vui lòng nhập lại mật khẩu';
        return $messages;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $rules['password_old'] = ['required'];
        $rules['password'] = ['required','confirmed','min:6'];
        $rules['password_confirmation'] = ['required','min:6'];
        return $rules;
    }
}
