<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Yajra\Datatables\Datatables;
use App\Http\Requests\Backend\MstPositionCreateRequest;
use App\Http\Requests\Backend\MstPositionUpdateRequest;
use App\MstPosition;
use DB;
class MstPositionController extends Controller
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

    public function index(Request $request){
        return view('backend.mstposition.index');
    }
    public function getDataMstPosition(Request $request){
        $mstPosition = MstPosition::select(
            ['id','pst_name','pst_coefficient','pst_delete_flag','pst_created_at']
        )->where('pst_delete_flag','=','1');
        return Datatables::of($mstPosition)
            ->addColumn('action', function ($mstPosition) {
                return '<a href="javascript:void(0)" data-url='.route('mst_position.update', ['id' => $mstPosition->id]).' class="btn btn-xs btn-primary btn-edit-position"><i class="glyphicon glyphicon-edit"></i>'.trans('labels.backend.common.edit').'</a> <a href="javascript:void(0)" data-id='.$mstPosition->id.' data-url='.route('mst_position.delete',['id' => $mstPosition->id]).' class="btn btn-xs btn-danger btn-delete-position"><i class="fa fa-power-off"></i>'.trans('labels.backend.common.delete').'</a>';
            })
        ->make(true);
    }
    public function create(MstPositionCreateRequest $request){
        $inputData = $request->all();
        $mstPosition = new MstPosition();
        $mstPosition['pst_name'] = $inputData['pst_name'];
        $mstPosition['pst_coefficient'] = $inputData['pst_coefficient'];
        $mstPosition['pst_delete_flag'] = '1';
        $mstPosition['pst_created_at'] = date("Y-m-d h:i:s");
        $mstPosition['pst_updated_at'] = date("Y-m-d h:i:s");
        $result = $mstPosition->save();
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_success'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_position.index');
        }
    }
    public function update(MstPositionUpdateRequest $request){
        $inputData = $request->all();
        $result = DB::table('mst_position')
              ->where('id', $inputData['id'])
              ->update(['pst_updated_at' => date("Y-m-d h:i:s"),'pst_name' => $inputData['pst_name'],'pst_coefficient' => $inputData['pst_coefficient']]);
        if ($result) {
            $request->session()->forget('screen');
            toastr()->success(trans('labels.backend.common.msg_edit'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_position.index');
        }
    }
    public function delete(Request $request){
        $inputData = $request->all();
        $result = DB::table('mst_position')
              ->where('id', $inputData['id'])
              ->update(['pst_updated_at' => date("Y-m-d h:i:s"),'pst_delete_flag' => '0']);
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_position.index');
        }
    }
}