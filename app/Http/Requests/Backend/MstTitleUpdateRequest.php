<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MstTitleUpdateRequest extends FormRequest
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
            'ttl_name.required' => 'Vui lòng nhập tên chức danh',
            'ttl_name.unique' => 'Chức danh đã tồn tại',
            'ttl_name.max' => 'Tên chức danh dài quá 150 kí tự',
            'ttl_quota.required' => 'Vui lòng nhập định mức',
            'ttl_quota.numeric' => 'Định mức phải nhập là số',
            'ttl_group_learn.required' => 'Vui lòng nhập nhóm môn',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        session(['screen' => 'edit']);
        session(['id' => $this->id]);
        return [
            'ttl_name'    => ['required','max:150',Rule::unique('mst_title')->where(function ($query) {
                return $query->where('ttl_delete_flag', 1)->where('id','!=',$this->id);
            })],
            'ttl_quota' => ['required','numeric'],
            'ttl_group_learn' => 'required',
        ];
    }
}
