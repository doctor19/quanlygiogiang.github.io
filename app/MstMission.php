<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class MstMission extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','msn_id_semester','msn_lesson','msn_learn','msn_count_schedule','msn_teach_room','msn_batch','msn_id_user','msn_id_term','msn_id_class','msn_count_student','msn_describe','msn_type_teach','msn_date_teach','msn_delete_flag','msn_created_at','msn_updated_at'
    ];
    protected $table = 'mst_mission';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'usr_password', 'usr_remember_token',
    // ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    // protected $casts = [
    //     'usr_email_verified_at' => 'datetime',
    // ];
    public $timestamps = false;
}
