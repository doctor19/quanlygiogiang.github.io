<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class MstLogUsers extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','lg_id_users','lg_id_title','lg_id_position','lg_id_unit','lg_delete_flag','lg_id_semester','lg_created_at','lg_updated_at'
    ];
    protected $table = 'mst_log_users';

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
