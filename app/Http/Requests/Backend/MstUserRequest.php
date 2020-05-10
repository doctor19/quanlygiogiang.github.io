<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MstUserRequest extends FormRequest
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
        $messages = [
            // 'name.required' => 'Vui lòng nhập họ tên',
            // 'code.required' => 'Vui lòng nhập mã giảng viên',
            // 'code.unique' => 'Mã giảng viên đã tồn tại',
            // 'email.required' => 'Vui lòng nhập địa chỉ email',
            // 'email.email' => 'Định dạng email không hợp lệ',
            // 'email.unique' => 'Địa chỉ email đã tồn tại',
            // 'email.max' => 'Địa chỉ email dài quá 150 kí tự',
            // 'date_of_birth.required'  => 'Vui lòng chọn ngày sinh',
            'mst_title.required'  => 'Vui lòng chọn chức danh',
            //'mst_position.required' => 'Vui lòng chọn chức vụ',
            'mst_unit.required' => 'Vui lòng chọn đơn vị',
            'role.required' => 'Vui lòng chọn quyền',
        ];
        if (session('screen') == 'add') {
            $messages['name.required'] = 'Vui lòng nhập họ tên';
            $messages['code.required'] = 'Vui lòng nhập mã giảng viên';
            $messages['code.unique'] = 'Mã giảng viên đã tồn tại';
            $messages['email.required'] = 'Vui lòng nhập địa chỉ email';
            $messages['email.email'] = 'Định dạng email không hợp lệ';
            $messages['email.unique'] = 'Địa chỉ email đã tồn tại';
            $messages['email.max'] = 'Địa chỉ email dài quá 150 kí tự';
            $messages['date_of_birth.required']  = 'Vui lòng chọn ngày sinh';
            // $messages['password.required']  = 'Vui lòng nhập mật khẩu';
            // $messages['password.min']  = 'Mật khẩu phải lớn hơn 6 kí tự';
            // $messages['password.confirmed']   = 'Mật khẩu không khớp nhau';
            // $messages['password_confirmation.min']  = 'Xác nhận mật khẩu phải lớn hơn 6 kí tự';
            // $messages['password_confirmation.required']   = 'Vui lòng nhập lại mật khẩu';
        }
        return $messages;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            // 'name' => 'required',
            // 'code'    => ['required','max:50',Rule::unique('users')->where(function ($query) {
            //     if (session('screen') == 'add') {
            //         return $query->where('delete_flag', 1);
            //     } else {
            //         return $query->where('delete_flag', 1)->where('id','!=',$this->id);
            //     }
            // })],
            // 'email'    => ['required','email','max:150',Rule::unique('users')->where(function ($query) {
            //     if (session('screen') == 'add') {
            //         return $query->where('delete_flag', 1);
            //     } else {
            //         return $query->where('delete_flag', 1)->where('id','!=',$this->id);
            //     }
            // })],
            // 'date_of_birth' => 'required',
            'mst_title' => 'required',
            //'mst_position' => 'required',
            //'mst_unit' => 'required',
            'role' => 'required',
        ];
        if (session('screen') == 'add') {
            $rules['name'] = 'required';
            $rules['code']    = ['required','max:50',Rule::unique('users')->where(function ($query) {
                //if (session('screen') == 'add') {
                    return $query->where('delete_flag', 1);
                // } else {
                //     return $query->where('delete_flag', 1)->where('id','!=',$this->id);
                // }
            })];
            $rules['email']    = ['required','email','max:150',Rule::unique('users')->where(function ($query) {
                //if (session('screen') == 'add') {
                    return $query->where('delete_flag', 1);
                // } else {
                //     return $query->where('delete_flag', 1)->where('id','!=',$this->id);
                // }
            })];
            $rules['date_of_birth'] = 'required';
            // $rules['password'] = ['required','confirmed','min:6'];
            // $rules['password_confirmation'] = ['required','min:6'];
        }
        return $rules;
    }
}
