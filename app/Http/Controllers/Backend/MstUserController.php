<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;
use Yajra\Datatables\Datatables;
use App\User;
use App\MstUnit;
use App\MstPosition;
use App\MstTitle;
use App\MstSemester;
use App\Http\Requests\Backend\MstUserRequest;
use App\Http\Requests\Backend\MstUserChangePassRequest;
use App\Http\Requests\Backend\MstUserChangeInfoRequest;
use Hash;
use DB;
use Redirect;
use App\MstLogUsers;
class MstUserController extends Controller
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
        return view('backend.mstusers.index',['dataDefault' => $this->setDefault()]);
    }
    public function getDataUsers(Request $request){
        $users = User::select(
            ['users.id','users.code', 'users.name', 'users.email','users.gender' ,'users.role','users.active','users.created_at','mst_position.pst_name','users.date_of_birth' , 'mst_title.ttl_name']
        )
        ->leftJoin('mst_title', 'mst_title.id', '=', 'users.id_title')
        ->leftJoin('mst_position', 'mst_position.id', '=', 'users.id_position')->where('users.delete_flag',1);
        return Datatables::of($users)
            ->filter(function ($query) use ($request) {
                if ($request->has('name') && $request->get('name') != '') {
                    $query->where('name', 'like', "%{$request->get('name')}%");
                }
                if ($request->has('email') && $request->get('email') != '') {
                    $query->where('email', 'like', "%{$request->get('email')}%");
                }
                if ($request->has('gender') && $request->get('gender') != '') {
                    $query->where('gender',$request->get('gender'));
                }
                if ($request->has('active') && $request->get('active') != '') {
                    $query->where('active',$request->get('active'));
                }
                if ($request->has('mst_position') && $request->get('mst_position') != '') {
                    $query->where('id_position',$request->get('mst_position'));
                }
                if ($request->has('mst_title') && $request->get('mst_title') != '') {
                    $query->where('id_title',$request->get('mst_title'));
                }
                if ($request->has('id_unit') && $request->get('id_unit') != '') {
                    $query->where('id_unit',$request->get('id_unit'));
                }
            })
            ->editColumn('role', function ($user) {
                if ($user->role == 1) {
                    return '<span class="badge bg-red">Quản trị viên</span>';
                } else {
                    return '<span class="badge bg-light-blue">Giảng Viên</span>';
                }
            })
            ->editColumn('gender', function ($user) {
                if ($user->gender == 1) {
                    return '<span class="badge bg-green">Nam</span>';
                } else {
                    return '<span class="badge bg-light-blue">Nữ</span>';
                }
            })
            ->editColumn('active', function ($user) {
                if ($user->active == 1) {
                    return '<span class="label label-success">'.trans('labels.backend.common.active').'</span>';
                } else {
                    return '<span class="label label-danger">'.trans('labels.backend.common.deactive').'</span>';;
                }
            })
            ->editColumn('created_at', function ($user) {
                return date('Y-m-d', strtotime($user->created_at));
            })
            ->editColumn('date_of_birth', function ($user) {
                return date('d/m/Y', strtotime($user->date_of_birth));
            })
            ->addColumn('action', function ($user) {
                if ($user->active == 1) {
                    return '<p><a href='.route('mst_users.edit',['id'=>$user->id]).' class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>'.trans('labels.backend.common.edit').'</a> <a href="javascript:void(0)" data-url="'.route('mst_users.deactiveandactive',['id'=>$user->id, 'ac' => 0]).'" class="btn-click-deactive btn btn-xs btn-danger"><i class="fa fa-power-off"></i>'.trans('labels.backend.common.deactive').'</a> <a href="javascript:void(0)" data-url="'.route('mst_users.resetpass',['id'=>$user->id]).'" class="btn-click-reset btn btn-xs bg-green"><i class="fa fa-refresh"></i>'.trans('labels.backend.users.form.btn_reset_pass').'</a></p>';
                } else {
                    return '<p><a href='.route('mst_users.edit',['id'=>$user->id]).' class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i>'.trans('labels.backend.common.edit').'</a> <a href="javascript:void(0)" data-url="'.route('mst_users.deactiveandactive',['id'=>$user->id, 'ac' => 1]).'" class="btn-click-active btn btn-xs bg-green"><i class="fa fa-power-off"></i>'.trans('labels.backend.common.active').'</a> <a href="javascript:void(0)" data-url="'.route('mst_users.resetpass',['id'=>$user->id]).'" class="btn-click-reset btn btn-xs bg-green"><i class="fa fa-refresh"></i>'.trans('labels.backend.users.form.btn_reset_pass').'</a></p>';
                }
            })
            ->addColumn('checkbox',function($user) {
                return '<input type="checkbox" class="btn-click-checkbox" value="'.$user->id.'">';
            })
            ->rawColumns(['active','action','gender','role','checkbox'])
        ->make(true);
    }
    public function addUser(){
        session(['screen' => 'add']);
        return view('backend.mstusers.show_detail_create',['dataDefault' => $this->setDefault()]);
    }
    public function postAdd(MstUserRequest $request){
        $inputData = $request->all();
        DB::beginTransaction();
        try {
            $result = User::create(
                [
                    'name'=> $inputData['name'],
                    'code'=> $inputData['code'],
                    'email'=> $inputData['email'],
                    'password'=> Hash::make($inputData['date_of_birth']),
                    'gender'=> $inputData['gender'],
                    'date_of_birth'=> date("Y-m-d", strtotime(str_replace('/', '-', $inputData['date_of_birth']))),
                    'role'=> $inputData['role'],
                    'id_title'=> $inputData['mst_title'],
                    'id_position'=> $inputData['mst_position'],
                    'id_unit'=> $inputData['mst_unit'],
                    'active'=> '1',
                    'delete_flag'=> '1',
                    'created_at' => date("Y-m-d h:i:s"),
                    'updated_at' => date("Y-m-d h:i:s"),
                ]
            )->id;
            $userLog = new MstLogUsers();
            $userLog['lg_id_users'] = $result;
            $userLog['lg_id_title'] = $inputData['mst_title'];
            $userLog['lg_id_position'] = $inputData['mst_position'];
            $userLog['lg_id_unit'] = $inputData['mst_unit'];
            $userLog['lg_id_semester'] = $inputData['id_semester'];
            $userLog['lg_delete_flag'] = '1';
            $userLog['lg_created_at'] = date("Y-m-d h:i:s");
            $userLog['lg_updated_at'] = date("Y-m-d h:i:s");
            $resultLogUser = $userLog->save();
            // dd($resultLogUser);
            DB::commit();
            if($resultLogUser){
                toastr()->success(trans('labels.backend.common.msg_success'), trans('labels.backend.common.noti'));
                return redirect()->route('mst_users.index');
            }
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error(trans('labels.backend.common.msg_add_error'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_users.index');
        }
    }
    public function editUser(Request $request){
        session(['screen' => 'edit']);
        $inputData = $request->all();
        if (!isset($inputData['id'])) {
            abort(500);
        }
        $getUser = User::select(
            ['users.*','mst_log_users.lg_id_semester']
        )->leftJoin('mst_log_users', 'mst_log_users.lg_id_users', '=', 'users.id')->where('users.id', $inputData['id'])->first();
        if (!empty($getUser)) {
            session(['user_info_edit' => $getUser]);
            return view('backend.mstusers.show_detail_edit',['dataDefault' => $this->setDefault(),'user' => $getUser]);
        }
        abort(404);
    }
    public function postEdit(MstUserRequest $request){
        // $getUserInfo = session()->get('user_info');
        $inputData = $request->all();
        // $isCheckRequest = true;
        $arrUpdate = array(
            // 'name' => $inputData['name'],
            // 'code' =>  $inputData['code'],
            // 'email' =>  $inputData['email'],
            // 'gender' => $inputData['gender'],
            // 'date_of_birth' => date("Y-m-d", strtotime(str_replace('/', '-', $inputData['date_of_birth']))),
            'id_unit' => $inputData['mst_unit'],
            'id_title' => $inputData['mst_title'],
            'id_position' => $inputData['mst_position'],
        );
        DB::beginTransaction();
        try {
            $getLogUser = MstLogUsers::where('lg_id_users', $inputData['id'])->where('lg_id_semester',$inputData['id_semester'])->first();
            $result = DB::table('users')
                  ->where('id', $inputData['id'])
                  ->update($arrUpdate);
            $resultLogUser = true;
            if(!empty($getLogUser)) {
                $arrLogUser = array(
                    'lg_id_title' => $inputData['mst_title'],
                    'lg_id_position' => $inputData['mst_position'],
                    'lg_id_unit' => $inputData['mst_unit'],
                    'lg_id_semester' => $inputData['id_semester'],
                    'lg_updated_at' => date("Y-m-d h:i:s"),
                );
                $resultLogUser = DB::table('mst_log_users')
                ->where('id', $getLogUser['id'])
                ->update($arrLogUser);
            }
            DB::commit();
            if ($result || $resultLogUser) {
                $request->session()->forget('screen');
                toastr()->success(trans('labels.backend.common.msg_edit'), trans('labels.backend.common.noti'));
                return redirect()->route('mst_users.index');
            }
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            toastr()->error(trans('labels.backend.common.msg_add_error'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_users.index');
            // something went wrong
        }
        abort(500);
    }
    public function setDefault(){
        $result = [];
        $result['MstRole'] =  config('constant')['role'];
        $result['MstActive'] =  config('constant')['active'];
        $result['MstGender'] =  config('constant')['gender'];
        $result['MstRole'] =  config('constant')['role'];

        $arrMstTitle = [];
        foreach(MstTitle::select('id','ttl_name')->where('ttl_delete_flag',1)->get() as $value) {
            $arrMstTitle[''] = '';
            $arrMstTitle[$value['id']] = $value['ttl_name'];
        }
        $result['MstTitle'] = $arrMstTitle;

        $arrMstPosition = [];
        foreach(MstPosition::select('id','pst_name')->where('pst_delete_flag',1)->get() as $value) {
            $arrMstPosition[''] = '';
            $arrMstPosition[$value['id']] = $value['pst_name'];
        }
        $result['MstPosition'] =  $arrMstPosition;

        $arrMstUnit = [];
        foreach(MstUnit::select('id','unt_name')->where('unt_delete_flag',1)->get() as $value) {
            $arrMstUnit[''] = '';
            $arrMstUnit[$value['id']] = $value['unt_name'];
        }
        $result['MstUnit'] = $arrMstUnit;
        //tuyenhv
        $arrMstSemester = [];
        $MstSemesterStart = (date("Y") - 1).'_'.date("Y").'_1';
        $MstSemesterEnd = (date("Y") - 1).'_'.date("Y").'_2';
        $MstSemester = MstSemester::select('id','smt_name')->where('smt_delete_flag',1)
        //->whereIn('smt_name', [$MstSemesterStart,$MstSemesterEnd])
        ->orderBy('smt_name','desc')->get();
        foreach($MstSemester as $value) {
            $arrMstSemester[''] = '';
            $arrMstSemester[$value['id']] = $value['smt_name'];
        }
        $result['MstSemester'] = $arrMstSemester;

        return $result;
    }
    public function deactiveAndActive(Request $request) {
        $inputData = $request->all();
        if ($inputData['ac'] == '1' || $inputData['ac'] == '0') {
            $arrUpdate = array(
                'active' => $inputData['ac'],
                'updated_at' => date("Y-m-d h:i:s")
            );
            $result = DB::table('users')
                  ->where('id', $inputData['id'])
                  ->update($arrUpdate);
            if ($result) {
                toastr()->success($inputData['ac'] == '1' ? trans('labels.backend.users.active') : trans('labels.backend.users.deactive'), trans('labels.backend.common.noti'));
                return redirect()->route('mst_users.index');
            }
        }
        abort(500);
    }
    public function delete(Request $request){
        $inputData = $request->all();
        if($inputData['id'] == ''){
            toastr()->error(trans('labels.backend.common.msg_empty_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_users.index');
        }
        $arrUpdate = array(
            'delete_flag' => 0,
            'updated_at' => date("Y-m-d h:i:s")
        );
        $result = DB::table('users')
              ->whereIn('id', explode(',',$inputData['id']))
              ->update($arrUpdate);
        if ($result) {
            toastr()->success(trans('labels.backend.common.msg_delete'), trans('labels.backend.common.noti'));
            return redirect()->route('mst_users.index');
        }
        abort(500);
    }
    public function changePass(){
        return view('backend.mstusers.changepass');
    }
    public function postChangePass(MstUserChangePassRequest $request){
        $inputData = $request->all();
        if (!Hash::check($inputData['password_old'], Auth::user()->password)) {
            return Redirect::back()->withErrors([trans('labels.backend.common.msg_error_pass')]);
        } else {
            $arrUpdate = array(
                'password' => Hash::make($inputData['password']),
                'updated_at' => date("Y-m-d h:i:s")
            );
            $result = DB::table('users')
                  ->where('id', Auth::user()->id)
                  ->update($arrUpdate);
            if ($result) {
                toastr()->success(trans('labels.backend.common.msg_changepass'), trans('labels.backend.common.noti'));
                return redirect()->route('dashboard');
            }
        }
    }
    public function resetPass(Request $request) {
        $inputData = $request->all();
        $getUser = User::where('id', $inputData['id'])->first();
        if (!empty($getUser)) {
            $pass = date("d/m/Y", strtotime(str_replace('/', '-', $getUser['date_of_birth'])));
            $arrUpdate = array(
                'password' => Hash::make($pass),
                'updated_at' => date("Y-m-d h:i:s")
            );
            $result = DB::table('users')
                  ->where('id', $inputData['id'])
                  ->update($arrUpdate);
            if ($result) {
                toastr()->success(trans('labels.backend.users.reset_pass'), trans('labels.backend.common.noti'));
                return redirect()->route('mst_users.index');
            }
        }
        abort(500);
    }
    public function showChangeInfo(Request $request){
        session(['screen' => 'change_info']);
        $inputData = $request->all();
        if (!isset($inputData['id'])) {
            abort(500);
        }
        //$getUser = User::where('id', $inputData['id'])->first();
        $getUser = User::select(
            ['users.*','mst_log_users.lg_id_semester']
        )->leftJoin('mst_log_users', 'mst_log_users.lg_id_users', '=', 'users.id')->where('users.id', $inputData['id'])
        ->orderBy('mst_log_users.id','desc')->first();
        if ($getUser['id'] != Auth::user()->id) {
            abort(500);
        }
        if (!empty($getUser)) {
            session(['user_info' => $getUser]);
            return view('backend.mstusers.show_detail_edit_info',['dataDefault' => $this->setDefault(),'user' => $getUser]);
        }
        abort(500);
    }
    public function postChangeInfo(MstUserChangeInfoRequest $request){
        $getUserInfo = session()->get('user_info');
        $inputData = $request->all();
        // $isCheckRequest = true;
        $arrUpdate = array(
            'name' => $inputData['name'],
            'gender' => $inputData['gender'],
            'date_of_birth' => date("Y-m-d", strtotime(str_replace('/', '-', $inputData['date_of_birth']))),
            'id_unit' => $inputData['mst_unit'],
            'id_title' => $inputData['mst_title'],
            'id_position' => $inputData['mst_position']
        );
        DB::beginTransaction();
        try {
            $getLogUser = MstLogUsers::where('lg_id_users', $inputData['id'])->where('lg_id_semester',$inputData['id_semester'])->first();
            $result = DB::table('users')
                  ->where('id', $inputData['id'])
                  ->update($arrUpdate);
            $resultLogUser = true;
            $arrLogUser = array(
                'lg_id_title' => $inputData['mst_title'],
                'lg_id_position' => $inputData['mst_position'],
                'lg_id_unit' => $inputData['mst_unit'],
                'lg_id_semester' => $inputData['id_semester'],
                'lg_updated_at' => date("Y-m-d h:i:s"),
            );
            if(!empty($getLogUser)) {
                $resultLogUser = DB::table('mst_log_users')
                ->where('id', $getLogUser['id'])
                ->update($arrLogUser);
            } else {
                $arrLogUser['lg_id_users'] = $inputData['id'];
                $resultLogUser = DB::table('mst_log_users')->insert(
                    $arrLogUser
                );
            }
            DB::commit();
            if ($result || $resultLogUser) {
                $request->session()->forget('screen');
                toastr()->success(trans('labels.backend.common.msg_change_info'), trans('labels.backend.common.noti'));
                return redirect()->route('dashboard');
            }
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
        abort(500);
    }
}
