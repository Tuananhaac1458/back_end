<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;  
class Option_Product_invoice extends Model
{
	 //
    use Notifiable;

	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option_name','price_option','type','id_invoice','id_product','id_product_invoice'
    ];

    public static function add($data){
        $data_insert = [
            "option_name" => $data->option_name,
            "price_option" => $data->price_option,
            "type" => $data->type,
            "id_invoice" => $data->id_invoice,
            "id_product" => $data->id_product,
            "id_product_invoice" => $data->id_product_invoice,
        ];
        $value=DB::table('option__product_invoices')
        ->insert($data_insert);
    }


    public static function get_with_id_invoice_product($obj){
        $value=DB::table('option__product_invoices')
        ->where('id_invoice',$obj->id_invoice)
        ->where('id_product',$obj->id_product)
        ->where('id_product_invoice',$obj->id_product_invoice)
        ->get();
        if($value->count() > 0){
        	return $value;
        }else{
        	return 0;
        }
    }


}
