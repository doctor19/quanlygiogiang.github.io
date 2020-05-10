<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Yajra\Datatables\Datatables;
use App\User;
use App\MstMission;
use DB;
use App\MstSemester;
use App\MstTerm;
use App\MstClass;
use App\MstTitle;
use App\MstPosition;
use App\MstUnit;
use App\Http\Requests\Backend\MstMissionRequest;
class MstMissionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
       DB::statement(DB::raw('set @rownum=0'));
        $mstMission = MstMission::select(
            [DB::raw('@rownum  := @rownum  + 1 AS rownum'),'mst_mission.msn_describe','mst_mission.id', 'mst_mission.msn_cls_name','mst_mission.msn_cls_count_student','mst_mission.msn_cls_coefficient','mst_mission.msn_batch','mst_term.tem_name','mst_term.tem_standard_time']
        )
        ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_mission.msn_id_semester')
        ->leftJoin('users', 'users.id', '=', 'mst_mission.msn_id_user')
        ->leftJoin('mst_term', 'mst_term.id', '=', 'mst_mission.msn_id_term')
        // ->leftJoin('mst_class', 'mst_class.id', '=', 'mst_mission.msn_id_class')
        ->leftJoin('mst_unit', 'mst_unit.id', '=', 'users.id_unit')->where('mst_mission.msn_id_user',Auth::user()->id)->where('mst_mission.msn_delete_flag',1)->get();
        return view('backend.mstmission.index',['dataDefault' => $this->setDefault()]);
    }
    public function getDataMstMission(Request $request){
        //DB::raw('SUM(mst_term.tem_standard_time * mst_mission.msn_cls_coefficient) as all_total'),
        DB::statement(DB::raw('set @rownum=0'));
        $mstMission = MstMission::select(
            [DB::raw('@rownum  := @rownum  + 1 AS rownum'),'mst_mission.msn_describe','mst_mission.id', 'mst_mission.msn_cls_name','mst_mission.msn_cls_count_student','mst_mission.msn_cls_coefficient','mst_mission.msn_batch','mst_term.tem_name','mst_term.tem_standard_time']
        )
        ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_mission.msn_id_semester')
        ->leftJoin('users', 'users.id', '=', 'mst_mission.msn_id_user')
        ->leftJoin('mst_term', 'mst_term.id', '=', 'mst_mission.msn_id_term')
        // ->leftJoin('mst_class', 'mst_class.id', '=', 'mst_mission.msn_id_class')
        ->leftJoin('mst_unit', 'mst_unit.id', '=', 'users.id_unit')->where('mst_mission.msn_id_user',Auth::user()->id)->where('mst_mission.msn_delete_flag',1);
        // ->groupBy('mst_mission.id', 'mst_mission.msn_cls_name','mst_mission.msn_cls_count_student','mst_mission.msn_cls_coefficient','mst_mission.msn_batch','mst_term.tem_name','mst_term.tem_standard_time');
        return Datatables::of($mstMission)
            ->filter(function ($query) use ($request) {
                if ($request->has('msn_id_semester') && $request->get('msn_id_semester') != '') {
                    $query->where('mst_mission.msn_id_semester',$request->get('msn_id_semester'));
                }
            })
            ->addColumn('action', function ($mstMission) {
                return '<a href='.route('mst_mission.edit',['id'=>$mstMission->id]).' class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>'.trans('labels.backend.common.edit').'</a>';
            })
            ->addColumn('checkbox',function($mstMission) {
                return '<input type="checkbox" class="btn-click-checkbox" value="'.$mstMission->id.'">';
            })
            ->addColumn('count_periods_in_calculated',function($mstMission){
                //he so x so gio chuan
                if(strpos(mb_strtolower($mstMission['tem_name'], 'UTF-8'),'hướng dẫn') != false){
                    return $mstMission->tem_standard_time * $mstMission->msn_cls_count_student;
                } else {
                    return $mstMission->tem_standard_time * $mstMission->msn_cls_coefficient;
                }
            })
            ->editColumn('msn_type_teach',function($mstMission){
                if($mstMission->msn_type_teach == '1'){
                    return 'Lý thuyết';
                }
                return 'Thực hành';
            })
            ->rawColumns(['action','checkbox'])
        ->make(true);
    }
    public function addMission(){
        session(['screen' => 'add']);
        return view('backend.mstmission.show_detail_create',['dataDefault' => $this->setDefault()]);
    }
    public function setDefault(){
        $result = [];
        $result['MsnLearn'] =  config('constant')['msn_learn'];
        $result['MsnTypeTech'] =  config('constant')['msn_type_teach'];
        $result['MsnBatch'] =  config('constant')['msn_batch'];
        
        $arrMstSemester = [];
        foreach(MstSemester::select('id','smt_name')->where('smt_delete_flag',1)->orderBy('smt_name','desc')->get() as $value) {
            $arrMstSemester[''] = '';
            $arrMstSemester[$value['id']] = $value['smt_name'];
        }
        $result['MstSemester'] = $arrMstSemester;

        $arrMstTerm = [];
        foreach(MstTerm::select('id','tem_name')->where('tem_delete_flag',1)->get() as $value) {
            $arrMstTerm[''] = '';
            $arrMstTerm[$value['id']] = $value['tem_name'];
        }
        $result['MstTerm'] = $arrMstTerm;

        $arrMstClass = [];
        foreach(MstClass::select('id','cls_name')->where('cls_delete_flag',1)->get() as $value) {
            $arrMstClass[''] = '';
            $arrMstClass[$value['id']] = $value['cls_name'];
        }
        $result['MstClass'] = $arrMstClass;
        return $result;
    }
    public function create(MstMissionRequest $request){
        $inputData = $request->all();
        if ($inputData['msn_batch'] == 1) {
            $getMstClass = MstClass::where('id', $inputData['msn_id_class'])->first();
        }
        $mission = new MstMission();
        $mission['msn_id_semester'] = $inputData['msn_id_semester'];
        $mission['msn_batch'] = $inputData['msn_batch'];
        $mission['msn_id_user'] = Auth::user()->id;
        $mission['msn_id_term'] = $inputData['msn_id_term'];
        $mission['msn_id_class'] = $inputData['msn_batch'] == 1 ? $inputData['msn_id_class'] : null;
        $mission['msn_cls_name'] = $inputData['msn_batch'] == 1 ? $getMstClass['cls_name'] : $inputData['cls_name'];
        $mission['msn_cls_count_student'] = $inputData['cls_count_student'];
        $mission['msn_cls_coefficient'] = $inputData['cls_coefficient'];
        $mission['msn_describe'] =  $inputData['msn_describe'];
        $mission['msn_delete_flag'] = '1';
        $mission['msn_created_at'] = date("Y-m-d h:i:s");
        $mission['msn_updated_at'] = date("Y-m-d h:i:s");
        $result = $mission->save();
        if($result){
            toastr()->success(trans('labels.backend.common.msg_success'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_mission.index');
        }
    }
    public function edit(Request $request){
        session(['screen' => 'edit']);
        $inputData = $request->all();
        if (!isset($inputData['id'])) {
            abort(500);
        }
        $getMstMission = MstMission::where('id', $inputData['id'])->first();
        if (!empty($getMstMission)) {
            return view('backend.mstmission.show_detail_edit',['dataDefault' => $this->setDefault(),'mstMisstion' => $getMstMission]);
        }
        abort(500);
    }
    public function editPost(MstMissionRequest $request){
        session(['screen' => 'edit']);
        $inputData = $request->all();
        $getMstMission = MstMission::where('id', $inputData['id'])->first();
        if ($getMstMission['msn_batch'] == 1) {
            $getMstClass = MstClass::where('id', $inputData['msn_id_class'])->first();
        }
        $arrUpdate = [];
        //$arrUpdate['msn_id_semester'] = $inputData['msn_id_semester'];
        // $arrUpdate['msn_lesson'] = $inputData['msn_lesson'];
        // $arrUpdate['msn_learn'] = $inputData['msn_learn'];
        // $arrUpdate['msn_teach_room'] = $inputData['msn_teach_room'];
        //$arrUpdate['msn_batch'] = $inputData['msn_batch'];
        $arrUpdate['msn_id_user'] = Auth::user()->id;
        $arrUpdate['msn_id_term'] = $inputData['msn_id_term'];

        $arrUpdate['msn_id_class'] = $getMstMission['msn_batch'] == 1 ? $inputData['msn_id_class'] : null;

        $arrUpdate['msn_cls_name'] = $getMstMission['msn_batch'] == 1 ? $getMstClass['cls_name'] : $inputData['cls_name'];
        $arrUpdate['msn_cls_count_student'] = $inputData['cls_count_student'];
        $arrUpdate['msn_cls_coefficient'] = $inputData['cls_coefficient'];

        $arrUpdate['msn_describe'] =  $inputData['msn_describe'];
        // $arrUpdate['msn_type_teach'] =  $inputData['msn_type_teach'];
        // $arrUpdate['msn_date_teach'] = date("Y-m-d", strtotime(str_replace('/', '-', $inputData['msn_date_teach_start'])));
        $arrUpdate['msn_updated_at'] = date("Y-m-d h:i:s");
        $result = DB::table('mst_mission')
              ->where('id', $inputData['id'])
              ->update($arrUpdate);
        if ($result) {
            $request->session()->forget('screen');
            toastr()->success(trans('labels.backend.common.msg_edit'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_mission.index');
        }
    }
    public function delete(Request $request){
        $inputData = $request->all();
        if($inputData['id'] == ''){
            toastr()->error(trans('labels.backend.common.msg_empty_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_mission.index');
        }
        $arrUpdate = array(
            'msn_delete_flag' => 0,
            'msn_updated_at' => date("Y-m-d h:i:s")
        );
        $result = DB::table('mst_mission')
              ->whereIn('id', explode(',',$inputData['id']))
              ->update($arrUpdate);
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_mission.index');
        }
        abort(500);
    }
}