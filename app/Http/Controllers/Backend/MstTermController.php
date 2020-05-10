<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Yajra\Datatables\Datatables;
use DB;
use App\MstTerm;
use App\Http\Requests\Backend\MstTermCreateRequest;
use App\Http\Requests\Backend\MstTermUpdateRequest;

class MstTermController extends Controller
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
        return view('backend.mstterm.index');
    }
    public function getDataMstTerm(Request $request){
        $mstTerm = MstTerm::select(
            ['id','tem_code','tem_name','tem_credit','tem_standard_time','tem_delete_flag','tem_count_theoretical_details','tem_count_practice','tem_count_discuss']
        )->where('tem_delete_flag','=','1');
        return Datatables::of($mstTerm)
            ->addColumn('action', function ($mstTerm) {
                if (Auth::user()->role == 1) {
                    return '<a href="javascript:void(0)" data-url='.route('mst_term.update', ['id' => $mstTerm->id]).' class="btn btn-xs btn-primary btn-edit-term"><i class="glyphicon glyphicon-edit"></i>'.trans('labels.backend.common.edit').'</a> <a href="javascript:void(0)" data-id='.$mstTerm->id.' data-url='.route('mst_term.delete',['id' => $mstTerm->id]).' class="btn btn-xs btn-danger btn-delete-term"><i class="fa fa-power-off"></i>'.trans('labels.backend.common.delete').'</a>';
                } else {
                    return '';
                }
            })
        ->make(true);
    }
    public function create(MstTermCreateRequest $request){
        $inputData = $request->all();
        $MstTerm = new MstTerm();
        $MstTerm['tem_code'] = $inputData['tem_code'];
        $MstTerm['tem_name'] = $inputData['tem_name'];
        $MstTerm['tem_credit'] = $inputData['tem_credit'];
        $MstTerm['tem_standard_time'] = $inputData['tem_count_theoretical_details'] + $inputData['tem_count_practice'] + $inputData['tem_count_discuss'];
        $MstTerm['tem_count_theoretical_details'] = $inputData['tem_count_theoretical_details'];
        $MstTerm['tem_count_practice'] = isset($inputData['tem_count_practice']) ? $inputData['tem_count_practice'] : 0;
        $MstTerm['tem_count_discuss'] = isset($inputData['tem_count_discuss']) ? $inputData['tem_count_discuss'] : 0;
        $MstTerm['tem_delete_flag'] = '1';
        $MstTerm['tem_created_at'] = date("Y-m-d h:i:s");
        $MstTerm['tem_updated_at'] = date("Y-m-d h:i:s");
        $result = $MstTerm->save();
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_success'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_term.index');
        }
        abort(500);
    }
    public function update(MstTermUpdateRequest $request){
        $inputData = $request->all();
        $arrData = array(
            'tem_code' => $inputData['tem_code'],
            'tem_name' => $inputData['tem_name'],
            'tem_credit' => $inputData['tem_credit'],
            'tem_standard_time' => $inputData['tem_count_theoretical_details'] + $inputData['tem_count_practice'] + $inputData['tem_count_discuss'],
            'tem_count_theoretical_details' => $inputData['tem_count_theoretical_details'],
            'tem_count_practice' => isset($inputData['tem_count_practice']) ? $inputData['tem_count_practice'] : 0,
            'tem_count_discuss' => isset($inputData['tem_count_discuss']) ? $inputData['tem_count_discuss'] : 0,
            'tem_updated_at' => date("Y-m-d h:i:s"),
        );
        $result = DB::table('mst_term')
              ->where('id', $inputData['id'])
              ->update($arrData);
        if ($result) {
            $request->session()->forget('screen');
            toastr()->success(trans('labels.backend.common.msg_edit'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_term.index');
        }
        abort(500);
    }
    public function delete(Request $request){
        $inputData = $request->all();
        $result = DB::table('mst_term')
              ->where('id', $inputData['id'])
              ->update(['tem_updated_at' => date("Y-m-d h:i:s"),'tem_delete_flag' => '0']);
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_term.index');
        }
        abort(500);
    }
}
