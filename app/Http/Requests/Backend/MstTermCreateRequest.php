<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class MstTermCreateRequest extends FormRequest
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
            'tem_code.required' => 'Vui lòng nhập mã học phần',
            'tem_code.unique' => 'Mã học phần đã tồn tại',
            'tem_name.required' => 'Vui lòng nhập tên học phần',
            'tem_name.max' => 'Tên học phần vượt quá mức cho phép',
            'tem_credit.required' => 'Vui lòng nhập số tín chỉ',
            'tem_credit.numeric' => 'Số tín chỉ phải nhập là số',
           
            'tem_count_theoretical_details.required' => 'Vui lòng nhập số tiết lý thuyết',
            'tem_count_theoretical_details.numeric' => 'Số tiết lý thuyết phải nhập là số',
            // 'tem_count_practice.required' => 'Vui lòng nhập số tiết thực hành',
            // 'tem_count_practice.numeric' => 'Số tiết thực hành phải nhập là số',
            // 'tem_count_discuss.required' => 'Vui lòng nhập số tiết thảo luận',
            // 'tem_count_discuss.numeric' => 'Số tiết thảo luận phải nhập là số',
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        $request->session()->forget('screen');
        return [
            'tem_code'    => ['required',Rule::unique('mst_term')->where(function ($query) {
                return $query->where('tem_delete_flag', 1);
            })],
            'tem_name' => ['required','max:150'],
            'tem_credit' => ['required','numeric'],
            'tem_count_theoretical_details' => ['required','numeric'],
            // 'tem_count_practice' => ['required','numeric'],
            // 'tem_count_discuss' => ['required','numeric'],
        ];
    }
}
