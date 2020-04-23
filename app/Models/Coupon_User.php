<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;  
class Coupon_User extends Model
{
    //
    //
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_coupon','id_user'
    ];


    public static function get_with_id_user($id){
        $value=DB::table('coupon__users')
        ->where('id_user',$id)
        ->join('coupons','coupons.id','=','coupon__users.id_coupon')
        ->where('status', 1)
        ->get();
        if($value->count() > 0){
            return $value;
        }else{
            return 0;
        }
    }
}
