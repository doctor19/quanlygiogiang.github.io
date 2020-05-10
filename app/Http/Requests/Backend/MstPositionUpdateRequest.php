<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class MstPositionUpdateRequest extends FormRequest
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
            'pst_name.required' => 'Vui lòng nhập tên chức vụ',
            'pst_name.unique' => 'Chức vụ đã tồn tại',
            'pst_name.max' => 'Tên chức vụ dài quá 150 kí tự',
            'pst_coefficient.required' => 'Vui lòng nhập hệ số',
            'pst_coefficient.numeric' => 'Hệ số phải nhập là số'
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        session(['screen' => 'edit']);
        session(['id' => $this->id]);
        return [
            'pst_name'    => ['required','max:150',Rule::unique('mst_position')->where(function ($query) {
                return $query->where('pst_delete_flag', 1)->where('id','!=',$this->id);
            })],
            'pst_coefficient' => ['required','numeric']
        ];
    }
}
