<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;  
class Invoice_Product extends Model
{
    //
    use Notifiable;

	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_invoice','id_product','id_product_invoice','amount'
    ];


    public static function add($data){
        $data_insert = [
            "id_invoice" => $data->id_invoice,
            "id_product" => $data->id_product,
            "id_product_invoice" => $data->id_product_invoice,
            "amount" => $data->amount,
        ];
        $value=DB::table('invoice__products')
        ->insert($data_insert);
    }

    public static function get_invoice_product_with_id($id){
        $value=DB::table('invoice__products')
        ->where('id_invoice',$id)
        ->get();
        if($value->count() < 0){
            return [];
        }
        return $value;
    }

}
