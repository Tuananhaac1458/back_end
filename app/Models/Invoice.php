<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;  
class Invoice extends Model
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
        'code_invoice','userName_invoice','userPhone_invoice','address_invoice','noteDriver_invoice',
        'noteStaff_invoice','totalMonney','money_driver','realMoney','status','id_coupon','id_user'
    ];


    public static function add($data){
        $value=DB::table('invoices')
        ->where('code_invoice', $data['code_invoice'])
        ->join('users','users.id','=','invoices.id_user')
        ->where('phone_verified_at', 1)
        ->first();
        if(isset($value)){
            return 0;
        }
        $time_now = date("Y-m-d H:i:s");
        $data['created_at'] = $time_now;
        $data['updated_at'] = $time_now;

        $value=DB::table('invoices')
        ->insert($data);
        return 1;
    }

    public static function getAll(){
        $value=DB::table('invoices')
        ->get();
        if($value->count() > 0){
            return $value;
        }
        return [];
    }


    public static function getAll_with_user_id($id){
        $value=DB::table('invoices')
        ->where('id_user',$id)
        ->latest()
        ->get();
        if($value->count() > 0){
            return $value;
        }
        return [];
    }


    public static function get_with_id($code_invoice){
        $value=DB::table('invoices')
        ->where('code_invoice', $code_invoice)
        ->first();

        if(empty($value)){
            return 0;
        }else{
            $user_Oder=DB::table('users')
            ->where('id', $value->id_user)
            ->first();

            $store=DB::table('stores')
            ->where('id', $value->id_store)
            ->first();

            $dataReturn = (object)[
                "id" => $value->id,
                "code_invoice" => $value->code_invoice,
                "userName_invoice" => $value->userName_invoice,
                "userPhone_invoice" => $value->userPhone_invoice,
                "address_invoice" => $value->address_invoice,
                "address_value_invoice" => $value->address_value_invoice,
                "noteDriver_invoice" => $value->noteDriver_invoice,
                "noteStaff_invoice" => $value->noteStaff_invoice,
                "totalMonney" => $value->totalMonney,
                "money_driver" => $value->money_driver,
                "realMoney" => $value->realMoney,
                "status" => $value->status,
                "store" => $store,
                "user_Oder" => (object)[
                    "id_user" => $user_Oder->id_user,
                    "phone_number" => $user_Oder->phone_number,
                    "user_name" => $user_Oder->user_name,
                ],
            ];
            if($value->id_coupon !== null){
                $value=DB::table('invoices')
                ->where('code_invoice', $code_invoice)
                ->join('coupons','coupons.id','=','invoices.id_coupon')
                ->first();
                $dataReturn->coupon = (object)[
                    "code_coupon" => $value->code_coupon,
                    "title_coupon" => $value->title_coupon,
                    "subtitle_coupon" => $value->subtitle_coupon,
                    "condition_coupon" => $value->condition_coupon,
                    "type_coupon" => $value->type_coupon,
                    "value_coupon" => $value->value_coupon,
                ];                 
            }

            return $dataReturn;
        }
    }


}
