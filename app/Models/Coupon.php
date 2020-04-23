<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;  


class Coupon extends Model
{
    //
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code_coupon','title_coupon','subtitle_coupon','condition_coupon','type_coupon',
        'value_coupon','expiry_day','status'
    ];




    public static function getAll(){
        $value=DB::table('coupons')
        ->get();
        if($value->count() > 0){
            return $value;
        }
        return [];
    }

    public static function getOne($id){
        $value=DB::table('coupons')
        ->where('code_coupon', $id)
        ->first();
        if(empty($value)){
            return [];
        }
        return $value;
    }

    public static function add($data){
        $value=DB::table('coupons')
        ->where('code_coupon', $data['code_coupon'])
        ->first();
        if(isset($value)){
            return 0;
        }
        $value=DB::table('coupons')
        ->insert($data);
        return 1;
    }

    public static function delete_Coupon($id){
        $value=DB::table('coupons')
        ->where('id', $id)
        ->first();
        if(empty($value)){
            return 0;
        }
        $value=DB::table('coupon__users')
        ->where('id_coupon', $id)
        ->delete();
        
        $value=DB::table('coupons')
        ->where('id', $id)
        ->delete();

        
        return 1;
    }

    
    public static function check_Coupon($data){
        $value=DB::table('coupon__users')
        ->where('code_coupon', $data->code_coupon)
        ->where('id_user', $data->id_user)
        ->join('coupons','coupons.id','=','coupon__users.id_coupon')
        ->where('status', 1)
        ->first();
        if(empty($value)){
            return 0;
        }
        return 1;
    }


    public static function add_Coupon_to_User($data){
        $value=DB::table('coupon__users')
        ->where('id_coupon', $data->id_coupon)
        ->where('id_user', $data->id_user)
        ->first();
        if(isset($value)){
            return 0;
        }
        $valueInsert = [
            "id_user" => $data->id_user,
            "id_coupon" => $data->id_coupon
        ];
        DB::table('coupon__users')
        ->insert($valueInsert);
        return 1;
    }

    public static function get_Coupon_with_code($code_coupon){
        $value=DB::table('coupons')
        ->where('code_coupon', $code_coupon)
        ->where('status', 1)
        ->first();
        if(isset($value)){
            return $value;
        }
        return 0;
    }

}
