<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\MstMission;
use App\MstTerm;
use Auth;
class MstMissionRequest extends FormRequest
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
        $getNameTerm = MstTerm::select(
                ['tem_name']
            )->where('id',$this->msn_id_term)->first();
        if (isset($this->id)) {
            $getMstMission = MstMission::select(
                ['mst_mission.id', 'mst_mission.msn_cls_name','mst_mission.msn_batch','msn_id_semester']
            )->where('id',$this->id)->first();
        }
        if ($this->msn_batch == 1 || (!empty($getMstMission) && $getMstMission['msn_batch'] == 1)) {
            $mstMission = MstMission::select(
                ['mst_term.tem_name','mst_mission.id', 'mst_mission.msn_cls_name','mst_class.cls_name','mst_semester.smt_name']
            )
            ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_mission.msn_id_semester')
            ->leftJoin('mst_term', 'mst_term.id', '=', 'mst_mission.msn_id_term')
            ->leftJoin('mst_class', 'mst_class.id', '=', 'mst_mission.msn_id_class')
            ->where('mst_class.id', $this->msn_id_class)
            ->where('mst_semester.id', isset($this->id) ? $getMstMission['msn_id_semester'] : $this->msn_id_semester)
            ->where('mst_term.id', $this->msn_id_term)
            ->where('mst_mission.msn_delete_flag',1)->first();
        } else {
            $mstMission = MstMission::select(
                ['mst_term.tem_name','mst_mission.id', 'mst_mission.msn_cls_name','mst_class.cls_name','mst_semester.smt_name']
            )
            ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_mission.msn_id_semester')
            ->leftJoin('mst_term', 'mst_term.id', '=', 'mst_mission.msn_id_term')
            ->leftJoin('mst_class', 'mst_class.id', '=', 'mst_mission.msn_id_class')
            ->where('mst_mission.msn_cls_name', $this->cls_name)
            ->where('mst_semester.id', isset($this->id) ? $getMstMission['msn_id_semester'] : $this->msn_id_semester)
            ->where('mst_term.id', $this->msn_id_term)
            ->where('mst_mission.msn_delete_flag',1)->first();
        }
        $messages = [
            //'msn_id_semester.required' => 'Vui lòng chọn học kỳ',
            // 'msn_learn.required' => 'Vui lòng chọn buổi học',
            // 'msn_lesson.required' => 'Vui lòng nhập tiết học',
            // 'msn_lesson.numeric' => 'Vui lòng nhập tiết học là kí tự số',
            'msn_id_term.required'  => 'Vui lòng chọn học phần',
            // 'msn_teach_room.required' => 'Vui lòng nhập phòng học',
            // 'msn_teach_room.numeric' => 'Vui lòng nhập phòng học là kí tự số',
            //'msn_batch.required' => 'Vui lòng nhập đợt',
            // 'msn_batch.numeric' => 'Vui lòng nhập đợt là kí tự số',
            //'msn_type_teach.required' => 'Vui lòng nhập kiểu dạy',
            //'msn_describe.required' => 'Vui lòng chọn quyền',
            //'msn_date_teach_start.required' => 'Vui lòng chọn thời gian dạy',
            'cls_count_student.required' => 'Vui lòng nhập số sinh viên',
            'cls_count_student.numeric' => 'Số sinh viên phải nhập là số',
        ];
        if (session('screen') != 'edit') {
            $messages['msn_id_semester.required'] = 'Vui lòng chọn học kỳ';
            $messages['msn_batch.required'] = 'Vui lòng nhập đợt';
            $messages['msn_batch.numeric'] = 'Vui lòng nhập đợt là kí tự số';
        }
        if ($this->msn_batch == 7 || $this->msn_batch == 12 || (!empty($getMstMission) && $getMstMission['msn_batch'] == 7) || (!empty($getMstMission) && $getMstMission['msn_batch'] == 12)) {
            //if (!empty($mstMission) && strpos(mb_strtolower($getNameTerm['tem_name'], 'UTF-8'),'hướng dẫn') == false) {
                $messages['msn_id_term.unique']  = 'Đã khai báo dạy học phần '.$mstMission['tem_name'].' cho lớp '.$mstMission['msn_cls_name'];
            // } else {
                
            // }
            $messages['cls_name.required'] = 'Vui lòng nhập tên lớp';
            $messages['cls_name.unique'] = 'Tên lớp đã tồn tại';
            $messages['cls_name.max'] = 'Tên lớp dài quá 150 kí tự';
        } else {
            //if (strpos(mb_strtolower($getNameTerm['tem_name'], 'UTF-8'),'hướng dẫn') == false) {
                $messages['msn_id_term.unique']  = 'Đã khai báo dạy học phần '.$mstMission['tem_name'].' cho lớp '.$mstMission['msn_cls_name'];
            //}
            $messages['msn_id_class.required'] = 'Vui lòng chọn lớp';
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
        $getNameTerm = MstTerm::select(
                ['tem_name']
            )->where('id',$this->msn_id_term)->first();
        if (isset($this->id)) {
            $getMstMission = MstMission::select(
                ['mst_mission.id', 'mst_mission.msn_cls_name','mst_mission.msn_batch']
            )->where('id',$this->id)->first();
        }
        if ($this->msn_batch == 1 || (!empty($getMstMission) && $getMstMission['msn_batch'] == 1)) {
            $mstMission = MstMission::select(
                ['mst_term.tem_name','mst_mission.id', 'mst_mission.msn_cls_name','mst_class.cls_name','mst_semester.smt_name']
            )
            ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_mission.msn_id_semester')
            ->leftJoin('mst_term', 'mst_term.id', '=', 'mst_mission.msn_id_term')
            ->leftJoin('mst_class', 'mst_class.id', '=', 'mst_mission.msn_id_class')
            ->where('mst_class.id', $this->msn_id_class)
            ->where('mst_semester.id', $this->msn_id_semester)
            ->where('mst_term.id', $this->msn_id_term)
            ->where('mst_mission.msn_delete_flag',1)->first();
        } else {
            $mstMission = MstMission::select(
                ['mst_term.tem_name','mst_mission.id', 'mst_mission.msn_cls_name','mst_class.cls_name','mst_semester.smt_name']
            )
            ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_mission.msn_id_semester')
            ->leftJoin('mst_term', 'mst_term.id', '=', 'mst_mission.msn_id_term')
            ->leftJoin('mst_class', 'mst_class.id', '=', 'mst_mission.msn_id_class')
            ->where('mst_mission.msn_cls_name', $this->cls_name)
            ->where('mst_semester.id', $this->msn_id_semester)
            ->where('mst_term.id', $this->msn_id_term)
            ->where('mst_mission.msn_delete_flag',1)->first();
        }
        $rules = [
            // 'msn_id_semester' => 'required',
            // 'msn_batch' => ['required','numeric'],
            'cls_count_student' => ['required','numeric'],
        ];
        if (session('screen') != 'edit') {
            $rules['msn_id_semester'] = 'required';
            $rules['msn_batch'] = ['required','numeric'];
        }
        if ($this->msn_batch == 1 || (!empty($getMstMission) && $getMstMission['msn_batch'] == 1)) {
            if(strpos(mb_strtolower($getNameTerm['tem_name'], 'UTF-8'),'hướng dẫn') == false){
                $rules['msn_id_term']    = ['required',Rule::unique('mst_mission')->where(function ($query) {
                    if (session('screen') == 'add') {
                        return $query->where('msn_delete_flag', 1)->where('msn_id_class', $this->msn_id_class)->where('msn_id_semester', $this->msn_id_semester);
                    } else {
                    return $query->where('msn_delete_flag', 1)->where('msn_id_class', $this->msn_id_class)->where('msn_id_semester', $this->msn_id_semester)->where('id','!=',$this->id);
                    }
                })];
            } else {
                // $rules['msn_id_term']    = ['required',Rule::unique('mst_mission')->where(function ($query) {
                //     if (session('screen') == 'add') {
                //         return $query->where('msn_delete_flag', 1)->where('msn_id_class', $this->msn_id_class)->where('msn_id_semester', $this->msn_id_semester);
                //     } else {
                //     return $query->where('msn_delete_flag', 1)->where('msn_id_class', $this->msn_id_class)->where('msn_id_semester', $this->msn_id_semester)->where('id','!=',$this->id);
                //     }
                // })];
                $rules['msn_id_term'] = 'required';
            }
            $rules['msn_id_class'] = 'required';
        } else {
            // if(strpos(mb_strtolower($getNameTerm['tem_name'], 'UTF-8'),'hướng dẫn') == false){
            //     $rules['msn_id_term'] = ['required',Rule::unique('mst_mission')->where(function ($query) {
            //         if (session('screen') == 'add') {
            //             return $query->where('msn_delete_flag', 1)->where('msn_cls_name', $this->cls_name)->where('msn_id_semester', $this->msn_id_semester);
            //         } else {
            //         return $query->where('msn_delete_flag', 1)->where('msn_cls_name', $this->cls_name)->where('msn_id_semester', $this->msn_id_semester)->where('id','!=',$this->id);
            //         }
            //     })];
            // } else {
            //     $rules['msn_id_term']    = ['required',Rule::unique('mst_mission')->where(function ($query) {
            //         if (session('screen') == 'add') {
            //             return $query->where('msn_delete_flag', 1)->where('msn_id_class', $this->msn_id_class)->where('msn_id_semester', $this->msn_id_semester);
            //         } else {
            //         return $query->where('msn_delete_flag', 1)->where('msn_id_class', $this->msn_id_class)->where('msn_id_semester', $this->msn_id_semester)->where('id','!=',$this->id);
            //         }
            //     })];
            // }
            $rules['msn_id_term'] = 'required';
            $rules['cls_name'] = 'required';
        }
        return $rules;
    }
}
