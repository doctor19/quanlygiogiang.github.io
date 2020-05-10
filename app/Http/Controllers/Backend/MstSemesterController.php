<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Yajra\Datatables\Datatables;
use App\MstSemester;
use App\MstLogUsers;
use App\Http\Requests\Backend\MstSemesterCreateRequest;
use App\Http\Requests\Backend\MstSemesterUpdateRequest;
use DB;
use Redirect;
class MstSemesterController extends Controller
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

    public function index(){
        return view('backend.mstsemester.index');
    }
    public function getDataMstSemester(Request $request){
        $MstSemester = MstSemester::select(
            ['id','smt_name','smt_delete_flag','smt_created_at']
        )->where('smt_delete_flag','=','1');
        return Datatables::of($MstSemester)
            ->addColumn('action', function ($MstSemester) {
                return '<a href="javascript:void(0)" data-url='.route('mst_semester.update', ['id' => $MstSemester->id]).' class="btn btn-xs btn-primary btn-edit-semester"><i class="glyphicon glyphicon-edit"></i>'.trans('labels.backend.common.edit').'</a> <a href="javascript:void(0)" data-id='.$MstSemester->id.' data-url='.route('mst_semester.delete',['id' => $MstSemester->id]).' class="btn btn-xs btn-danger btn-delete-semester"><i class="fa fa-power-off"></i>'.trans('labels.backend.common.delete').'</a>';
            })
        ->make(true);
    }
    public function create(MstSemesterCreateRequest $request){
        $inputData = $request->all();
        // $MstSemesterStart = (date("Y") - 1).'_'.date("Y").'_1';
        // $MstSemesterEnd = (date("Y") - 1).'_'.date("Y").'_2';
        // $MstSemesterList = MstSemester::select(
        //     ['id','smt_name','smt_delete_flag','smt_created_at']
        // )->where('smt_delete_flag','=','1')
        // ->whereIn('smt_name',[$MstSemesterStart,$MstSemesterEnd])->get();

        // if (!empty($MstSemesterList)) {
        //     return Redirect::back()->withErrors([trans('labels.backend.common.msg_semester_conflict')]);
        // }

        $MstSemester = (date("Y") - 2).'_'.(date("Y") - 1).'_2';
        $MstLogUsers = MstLogUsers::select(
            ['mst_log_users.id','mst_log_users.lg_id_users','mst_log_users.lg_id_title','mst_log_users.lg_id_position','mst_log_users.lg_id_unit','mst_log_users.lg_id_semester','mst_log_users.lg_delete_flag','mst_semester.smt_name']
        )->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_log_users.lg_id_semester')
        ->where('mst_semester.smt_name',$MstSemester)
        ->where('mst_semester.smt_delete_flag','=','1')
        ->where('mst_log_users.lg_delete_flag','=','1')->get();
        $result = MstSemester::create(
            [
                'smt_name'=> $inputData['smt_name'],
                'smt_delete_flag' => '1',
                'smt_created_at' => date("Y-m-d h:i:s"),
                'smt_updated_at' => date("Y-m-d h:i:s"),
            ]
        )->id;
        foreach($MstLogUsers as $value){
            $result = MstLogUsers::create(
                [
                    'lg_id_users' => $value['lg_id_users'],
                    'lg_id_title' => $value['lg_id_title'],
                    'lg_id_position' => $value['lg_id_position'],
                    'lg_id_unit' => $value['lg_id_unit'],
                    'lg_id_semester' => $result,
                    'lg_delete_flag' => '1',
                    'lg_created_at' => date("Y-m-d h:i:s"),
                    'lg_updated_at' => date("Y-m-d h:i:s"),
                ]
            );
        }
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_success'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_semester.index');
        }
    }
    public function delete(Request $request){
        $inputData = $request->all();
        $result = DB::table('mst_semester')
              ->where('id', $inputData['id'])
              ->update(['smt_updated_at' => date("Y-m-d h:i:s"),'smt_delete_flag' => '0']);
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_semester.index');
        }
    }
    public function update(MstSemesterUpdateRequest $request){
        $inputData = $request->all();
        $arrData = array(
            'smt_name' => $inputData['smt_name'],
            'smt_updated_at' => date("Y-m-d h:i:s"),
        );
        $result = DB::table('mst_semester')
              ->where('id', $inputData['id'])
              ->update($arrData);
        if ($result) {
            $request->session()->forget('screen');
            toastr()->success(trans('labels.backend.common.msg_edit'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_semester.index');
        }
    }
}
