<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Yajra\Datatables\Datatables;
use App\MstUnit;
use App\Http\Requests\Backend\MstUnitCreateRequest;
use App\Http\Requests\Backend\MstUnitUpdateRequest;
use DB;
class MstUnitController extends Controller
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
        // emotify('success', 'Thêm thành công');
        return view('backend.mstunit.index');
    }
    public function getDataMstUnit(Request $request){
        $mstUnit = MstUnit::select(
            ['id','unt_name','unt_delete_flag','unt_created_at']
        )->where('unt_delete_flag','=','1');
        return Datatables::of($mstUnit)
            ->addColumn('action', function ($mstUnit) {
                return '<a href="javascript:void(0)" data-url='.route('mst_unit.update', ['id' => $mstUnit->id]).' class="btn btn-xs btn-primary btn-edit-unit"><i class="glyphicon glyphicon-edit"></i>'.trans('labels.backend.common.edit').'</a> <a href="javascript:void(0)" data-id='.$mstUnit->id.' data-url='.route('mst_unit.delete',['id' => $mstUnit->id]).' class="btn btn-xs btn-danger btn-delete-unit"><i class="fa fa-power-off"></i>'.trans('labels.backend.common.delete').'</a>';
            })
        ->make(true);
    }
    public function create(MstUnitCreateRequest $request){
        $inputData = $request->all();
        $Unit = new MstUnit();
        $Unit['unt_name'] = $inputData['unt_name'];
        $Unit['unt_delete_flag'] = '1';
        $Unit['unt_created_at'] = date("Y-m-d h:i:s");
        $Unit['unt_update_at'] = date("Y-m-d h:i:s");
        $result = $Unit->save();
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_success'), trans('labels.backend.common.noti'));
            //notify()->preset('user-updated',array('title'=> trans('labels.backend.common.title_success'),'message'=> trans('labels.backend.common.msg_success')));
            return redirect()->route('mst_unit.index');
        }
    }
    public function update(MstUnitUpdateRequest $request){
        $inputData = $request->all();
        $result = DB::table('mst_unit')
              ->where('id', $inputData['id'])
              ->update(['unt_update_at' => date("Y-m-d h:i:s"),'unt_name' => $inputData['unt_name']]);
        if ($result) {
            $request->session()->forget('screen');
            toastr()->success(trans('labels.backend.common.msg_edit'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_unit.index');
        }
    }
    public function delete(Request $request){
        $inputData = $request->all();
        $result = DB::table('mst_unit')
              ->where('id', $inputData['id'])
              ->update(['unt_update_at' => date("Y-m-d h:i:s"),'unt_delete_flag' => '0']);
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_unit.index');
        }
    }
}