<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;  


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_user','id_social','phone_number', 'user_name', 'password','email','url_avatar','point','phone_verified_at','birt_day','token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
    //  *
    //  * @var array
    //  */
    // protected $casts = [
    //     'birt_day' => 'date',
    // ];


    public static function update_User($id,$data){
        $value=DB::table('users')
        ->where('id_user', $id)
        ->where('phone_verified_at', 1)
        ->get();
        if($value->count() > 0){
            $time_now = date("Y-m-d H:i:s");
            $data['updated_at'] = $time_now;
            DB::table('users')
            ->where('id_user', $id)
            ->update($data);
            return 1;
        }else{
            return 0;
        }
    }

    public static function insert_User($data){
        $value=DB::table('users')
        ->where('id_user', $data['id_user'])
        ->get();
        if($value->count() == 0){
            $time_now = date("Y-m-d H:i:s");
            $data['created_at'] = $time_now;
            $data['updated_at'] = $time_now;
            DB::table('users')->insert($data);
            return 1;
        }else{
            return 0;
        }
    }

    // public static function updateData($id,$data){
    //     DB::table('users')
    //     ->where('id_user', $id)
    //     ->update($data);
    // }

    public static function setPoint($id,$point){
        $value=DB::table('users')
        ->where('id_user', $id)
        ->where('phone_verified_at', 1)
        ->get();
        if($value->count() > 0){
            $time_now = date("Y-m-d H:i:s");
            $data['updated_at'] = $time_now;
            DB::table('users')
            ->where('id_user', $id)
            ->update([
                "point" => $point,
            ]);
            return 1;
        }else{
            return 0;
        }
    }
}
