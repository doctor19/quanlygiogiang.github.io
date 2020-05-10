<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MstUserChangeInfoRequest extends FormRequest
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
            'name.required' => 'Vui lòng nhập họ tên',
            'date_of_birth.required'  => 'Vui lòng chọn ngày sinh',
            'mst_title.required'  => 'Vui lòng chọn chức danh',
            // 'mst_position.required' => 'Vui lòng chọn chức vụ',
            // 'mst_unit.required' => 'Vui lòng chọn đơn vị',
        ];
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
            'name' => 'required',
            'date_of_birth' => 'required',
            'mst_title' => 'required',
            // 'mst_position' => 'required',
            // 'mst_unit' => 'required',
        ];
        return $rules;
    }
}
