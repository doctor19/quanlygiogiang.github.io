<?php

namespace App\Http\Controllers;

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
use App\MstLogUsers;

class HomeController extends Controller
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
        //so gio dạy thực tế
        $countActualHours = 0;
        //dinh muc giang day
        $countTeachingNorms = 0;
        $countUsers = 0;
        $countMstTerm = 0;
        $countMstClass = 0;
        $countMstUnit = 0;
        if(Auth::user()->role == 2) {
            $MstSemester = MstSemester::select('id','smt_name')->where('smt_delete_flag',1)->orderBy('smt_name','desc')->first();
            $MstSemesterStart = (date("Y") - 1).'_'.date("Y").'_1';
            $MstSemesterEnd = (date("Y") - 1).'_'.date("Y").'_2';
            $MstMission = MstMission::select(
                ['mst_semester.smt_name','mst_mission.msn_cls_coefficient','mst_mission.id', 'mst_mission.msn_cls_name','mst_mission.msn_cls_count_student','mst_term.tem_name','mst_term.tem_standard_time']
            )
            ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_mission.msn_id_semester')
            ->leftJoin('mst_term', 'mst_term.id', '=', 'mst_mission.msn_id_term')
            ->whereIn('mst_semester.smt_name',[$MstSemesterStart,$MstSemesterEnd])->where('mst_mission.msn_id_user',Auth::user()->id)->where('mst_mission.msn_delete_flag',1)->get();
            foreach($MstMission as $value) {
                if(strpos(mb_strtolower($value['tem_name'], 'UTF-8'),'hướng dẫn') != false){
                     $countActualHours += ($value['tem_standard_time'] * $value['msn_cls_count_student']);
                } else {
                    $countActualHours += ($value['tem_standard_time'] * $value['msn_cls_coefficient']);
                }
                if ($value['pst_coefficient'] != '') {
                    $countTeachingNorms += ($value['pst_coefficient'] * $value['ttl_quota']);
                } else {
                    $countTeachingNorms += (1 * $value['ttl_quota']);
                }
            }
            $type = 0;
            if(count($MstMission) == 0) {
                $type = 1;
            }
            $countTeachingNorms = $this->getTeachingNorms($MstSemesterStart,$MstSemesterEnd,$type);
            // $MstUser =  User::select(['users.id','mst_position.pst_coefficient','mst_title.ttl_quota','mst_semester.smt_name'])
            // ->leftJoin('mst_log_users', 'mst_log_users.lg_id_users', '=', 'users.id')
            // ->leftJoin('mst_position', 'mst_position.id', '=', 'mst_log_users.lg_id_position')
            // ->leftJoin('mst_title', 'mst_title.id', '=', 'mst_log_users.lg_id_title')
            // ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_log_users.lg_id_semester')
            // ->where('delete_flag',1)->whereIn('mst_semester.smt_name',[$MstSemesterStart,$MstSemesterEnd])->where('users.id',Auth::user()->id)->get();
            // foreach($MstUser as $value) {
            //     if ($value['pst_coefficient'] != '') {
            //         $countTeachingNorms += ($value['pst_coefficient'] * $value['ttl_quota']);
            //     } else {
            //         $countTeachingNorms += (1 * $value['ttl_quota']);
            //     }
            // }
            return view('backend.dashboard',['countMission' => count( $MstMission),'smtName' => (date("Y") - 1).'_'.date("Y"),'dataTable' =>  $this->getTotalYear() , 'countActualHours' => $countActualHours,'countTeachingNorms' => $countTeachingNorms,'countUsers'=>$countUsers,'countMstTerm'=>$countMstTerm,'countMstClass'=>$countMstClass,'countMstUnit'=>$countMstUnit]);
        } else {
            $countUsers = User::select(['id'])->where('delete_flag',1)->where('role',2)->count();
            $countMstTerm = MstTerm::select(['id'])->where('tem_delete_flag',1)->count();
            $countMstClass = MstClass::select(['id'])->where('cls_delete_flag',1)->count();
            $countMstUnit = MstUnit::select(['id'])->where('unt_delete_flag',1)->count();
            return view('backend.dashboard',['countTeachingNorms' => $countTeachingNorms,'countUsers'=>$countUsers,'countMstTerm'=>$countMstTerm,'countMstClass'=>$countMstClass,'countMstUnit'=>$countMstUnit]);
        }
        // dd(App::getLocale());
    }
    public function getTotalYear(){
        $arrDataTable = array();
        $MstMissionTable = MstMission::select(
            ['mst_semester.smt_name','mst_mission.msn_cls_coefficient','mst_mission.id', 'mst_mission.msn_cls_name','mst_mission.msn_cls_count_student','mst_term.tem_name','mst_term.tem_standard_time']
        )
        ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_mission.msn_id_semester')
        ->leftJoin('mst_term', 'mst_term.id', '=', 'mst_mission.msn_id_term')
        ->where('mst_mission.msn_id_user',Auth::user()->id)->where('mst_mission.msn_delete_flag',1)->get();
        $arrCheck = array();
        $countActualHours = 0 ;
        $countMission = [];
        foreach($MstMissionTable as $value) {
            $arrSmtName = explode('_',$value['smt_name']);
            $strCheck = $arrSmtName[0].'_'.$arrSmtName[1];
            if (!in_array($strCheck,$arrCheck)) {
                $arrCheck[] = $strCheck;
                if(strpos(mb_strtolower($value['tem_name'], 'UTF-8'),'hướng dẫn') != false){
                     $arrDataTable[$strCheck] = ($value['tem_standard_time'] * $value['msn_cls_count_student']);
                } else {
                    $arrDataTable[$strCheck] = ($value['tem_standard_time'] * $value['msn_cls_coefficient']);
                }
                $countMission[$strCheck] = 1;
            } else {
                if(strpos(mb_strtolower($value['tem_name'], 'UTF-8'),'hướng dẫn') != false){
                     $arrDataTable[$strCheck] += ($value['tem_standard_time'] * $value['msn_cls_count_student']);
                } else {
                    $arrDataTable[$strCheck] += ($value['tem_standard_time'] * $value['msn_cls_coefficient']);
                }
                // $arrDataTable[$strCheck] += ($value['tem_standard_time'] * $value['msn_cls_coefficient']);
                $countMission[$strCheck] += 1;
            }
        }
        $result['countMission'] = $countMission;
        $result['arrDataTable'] = $arrDataTable;
        $teachingNorms = [];
        foreach($result['arrDataTable'] as $key => $value){
            $teachingNorms[$key] = $this->getTeachingNorms($key.'_'.'1',$key.'_'.'2');
        }
        $result['teachingNorms'] = $teachingNorms;
        // if (empty($result['arrDataTable'])) {
        //     $MstLogUsers = MstLogUsers::select(
        //         'mst_log_users.id','mst_semester.smt_name','mst_position.pst_coefficient','mst_title.ttl_quota'
        //     )->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_log_users.lg_id_semester')
        //     ->leftJoin('mst_position', 'mst_position.id', '=', 'mst_log_users.lg_id_position')
        //     ->leftJoin('mst_title', 'mst_title.id', '=', 'mst_log_users.lg_id_title')->orderBy('mst_log_users.id','desc')
        //     ->get();
        //     foreach($MstLogUsers as $value) {
        //         $arrSmtName = explode('_',$value['smt_name']);
        //         $strCheck = $arrSmtName[0].'_'.$arrSmtName[1];
        //         if (!in_array($strCheck,$arrCheck)) {
        //             $arrCheck[] = $strCheck;
        //             if ($value['pst_coefficient'] != '') {
        //                 $arrDataTable[$strCheck] = ($value['pst_coefficient'] * $value['ttl_quota']);
        //             } else {
        //                 $arrDataTable[$strCheck] = (1 * $value['ttl_quota']);
        //             }
        //         } else {
        //             if ($value['pst_coefficient'] != '') {
        //                 $arrDataTable[$strCheck] += ($value['pst_coefficient'] * $value['ttl_quota']);
        //             } else {
        //                 $arrDataTable[$strCheck] += (1 * $value['ttl_quota']);
        //             }
        //         }
        //     }
        //     $result['teachingNorms'] = $arrDataTable;
        // }
        return $result;
    }
    public function getTeachingNorms($MstSemesterStart,$MstSemesterEnd,$type = null){
        $countTeachingNorms = 0;
        if ($type == 1) {
            $MstUser =  User::select(['users.id','mst_position.pst_coefficient','mst_title.ttl_quota','mst_semester.smt_name'])
            ->leftJoin('mst_log_users', 'mst_log_users.lg_id_users', '=', 'users.id')
            ->leftJoin('mst_position', 'mst_position.id', '=', 'mst_log_users.lg_id_position')
            ->leftJoin('mst_title', 'mst_title.id', '=', 'mst_log_users.lg_id_title')
            ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_log_users.lg_id_semester')
            ->where('delete_flag',1)->whereIn('mst_semester.smt_name',[$MstSemesterStart,$MstSemesterEnd])->where('users.id',Auth::user()->id)
            ->get();
        } else {
            $MstUser =  User::select(['users.id','mst_position.pst_coefficient','mst_title.ttl_quota','mst_semester.smt_name'])
            ->leftJoin('mst_log_users', 'mst_log_users.lg_id_users', '=', 'users.id')
            ->leftJoin('mst_position', 'mst_position.id', '=', 'mst_log_users.lg_id_position')
            ->leftJoin('mst_title', 'mst_title.id', '=', 'mst_log_users.lg_id_title')
            ->leftJoin('mst_semester', 'mst_semester.id', '=', 'mst_log_users.lg_id_semester')
            ->where('delete_flag',1)->whereIn('mst_semester.smt_name',[$MstSemesterStart,$MstSemesterEnd])->where('users.id',Auth::user()->id)
            ->whereExists(function($query) {
                $query->select('mst_mission.id')
                        ->from('mst_mission')
                        ->whereRaw('mst_mission.msn_id_semester = mst_semester.id');
            })
            ->get();
        }
        foreach($MstUser as $value) {
            if ($value['pst_coefficient'] != '') {
                $countTeachingNorms += ($value['pst_coefficient'] * $value['ttl_quota']);
            } else {
                $countTeachingNorms += (1 * $value['ttl_quota']);
            }
        }
        return $countTeachingNorms/2;
    }
}
