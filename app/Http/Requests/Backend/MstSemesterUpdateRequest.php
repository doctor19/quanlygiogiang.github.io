<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class MstSemesterUpdateRequest extends FormRequest
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
            'smt_name.required' => 'Vui lòng nhập tên học kì',
            'smt_name.unique' => 'Tên học kì đã tồn tại',
            'smt_name.max' => 'Tên học kì dài quá 150 kí tự',
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
            'smt_name'    => ['required','max:150',Rule::unique('mst_semester')->where(function ($query) {
                return $query->where('smt_delete_flag', 1)->where('id','!=',$this->id);
            })],
        ];
    }
}
