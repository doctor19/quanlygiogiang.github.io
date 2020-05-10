<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Session;
class MstUnitUpdateRequest extends FormRequest
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
            'unt_name.required' => 'Vui lòng nhập tên đơn vị',
            'unt_name.unique' => 'Tên đơn vị đã tồn tại',
            'unt_name.max' => 'Tên đơn vị dài quá 150 kí tự'
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
            'unt_name'    => ['required','max:150',Rule::unique('mst_unit')->where(function ($query) {
                return $query->where('unt_delete_flag', 1)->where('id','!=',$this->id);
            })],
        ];
    }
}
