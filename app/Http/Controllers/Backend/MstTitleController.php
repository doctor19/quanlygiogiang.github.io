<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Yajra\Datatables\Datatables;
use App\MstTitle;
use App\Http\Requests\Backend\MstTitleCreateRequest;
use App\Http\Requests\Backend\MstTitleUpdateRequest;
use DB;
class MstTitleController extends Controller
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
        return view('backend.msttitle.index');
    }
    public function getDataMstTitle(Request $request){
        $mstTitle = MstTitle::select(
            ['id','ttl_name','ttl_quota','ttl_group_learn','ttl_delete_flag','ttl_created_at']
        )->where('ttl_delete_flag','=','1');
        return Datatables::of($mstTitle)
            ->addColumn('action', function ($mstTitle) {
                return '<a href="javascript:void(0)" data-url='.route('mst_title.update', ['id' => $mstTitle->id]).' class="btn btn-xs btn-primary btn-edit-title"><i class="glyphicon glyphicon-edit"></i>'.trans('labels.backend.common.edit').'</a> <a href="javascript:void(0)" data-id='.$mstTitle->id.' data-url='.route('mst_title.delete',['id' => $mstTitle->id]).' class="btn btn-xs btn-danger btn-delete-title"><i class="fa fa-power-off"></i>'.trans('labels.backend.common.delete').'</a>';
            })
        ->make(true);
    }
    public function create(MstTitleCreateRequest $request){
        $inputData = $request->all();
        $MstTitle = new MstTitle();
        $MstTitle['ttl_name'] = $inputData['ttl_name'];
        $MstTitle['ttl_quota'] = $inputData['ttl_quota'];
        $MstTitle['ttl_group_learn'] = $inputData['ttl_group_learn'];
        $MstTitle['ttl_delete_flag'] = '1';
        $MstTitle['ttl_created_at'] = date("Y-m-d h:i:s");
        $MstTitle['ttl_updated_at'] = date("Y-m-d h:i:s");
        $result = $MstTitle->save();
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_success'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_title.index');
        }
    }
    public function update(MstTitleUpdateRequest $request){
        $inputData = $request->all();
        $arrData = array(
            'ttl_name' => $inputData['ttl_name'],
            'ttl_quota' => $inputData['ttl_quota'],
            'ttl_group_learn' => $inputData['ttl_group_learn'],
            'ttl_updated_at' => date("Y-m-d h:i:s"),
        );
        $result = DB::table('mst_title')
              ->where('id', $inputData['id'])
              ->update($arrData);
        if ($result) {
            $request->session()->forget('screen');
            toastr()->success(trans('labels.backend.common.msg_edit'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_title.index');
        }
    }
    public function delete(Request $request){
        $inputData = $request->all();
        $result = DB::table('mst_title')
              ->where('id', $inputData['id'])
              ->update(['ttl_updated_at' => date("Y-m-d h:i:s"),'ttl_delete_flag' => '0']);
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_title.index');
        }
    }
}
