<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Yajra\Datatables\Datatables;
use App\User;
use DB;
use App\MstClass;
use App\Http\Requests\Backend\MstClassCreateRequest;
use App\Http\Requests\Backend\MstClassUpdateRequest;
class MstClassController extends Controller
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
        return view('backend.mstclass.index',['valueDefault' => 0]);
    }
    public function getDataMstClass(Request $request){
        $mstClass = MstClass::select(
            ['id','cls_name','cls_describe','cls_delete_flag','cls_created_at']
        )->where('cls_delete_flag','=','1');
        return Datatables::of($mstClass)
            ->addColumn('action', function ($mstClass) {
                return '<a href="javascript:void(0)" data-url='.route('mst_class.update', ['id' => $mstClass->id]).' class="btn btn-xs btn-primary btn-edit-class"><i class="glyphicon glyphicon-edit"></i>'.trans('labels.backend.common.edit').'</a> <a href="javascript:void(0)" data-id='.$mstClass->id.' data-url='.route('mst_class.delete',['id' => $mstClass->id]).' class="btn btn-xs btn-danger btn-delete-class"><i class="fa fa-power-off"></i>'.trans('labels.backend.common.delete').'</a>';
            })
        ->make(true);
    }
    public function create(MstClassCreateRequest $request){
        $inputData = $request->all();
        $mstClass = new MstClass();
        $mstClass['cls_name'] = $inputData['cls_name'];
        $mstClass['cls_describe'] = $inputData['cls_describe'];
        $mstClass['cls_delete_flag'] = '1';
        $mstClass['cls_created_at'] = date("Y-m-d h:i:s");
        $mstClass['cls_updated_at'] = date("Y-m-d h:i:s");
        $result = $mstClass->save();
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_success'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_class.index');
        }
    }
    public function update(MstClassUpdateRequest $request){
        $inputData = $request->all();
        $arrData = array(
            'cls_name' => $inputData['cls_name'],
            'cls_describe' => $inputData['cls_describe'],
            'cls_updated_at' => date("Y-m-d h:i:s"),
        );
        $result = DB::table('mst_class')
              ->where('id', $inputData['id'])
              ->update($arrData);
        if ($result) {
            $request->session()->forget('screen');
            toastr()->success(trans('labels.backend.common.msg_edit'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_class.index');
        }
    }
    public function delete(Request $request){
        $inputData = $request->all();
        $result = DB::table('mst_class')
              ->where('id', $inputData['id'])
              ->update(['cls_updated_at' => date("Y-m-d h:i:s"),'cls_delete_flag' => '0']);
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_class.index');
        }
    }
}