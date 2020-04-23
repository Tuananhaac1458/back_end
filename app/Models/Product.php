<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;  
class Product extends Model
{
    //
    use Notifiable;

	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_product','name_product','price_product', 'image', 'description','status'
    ];


    

    public static function getAll(){

        $_return = DB::table('products')->where('status', true)->get();

        if($_return->count() == 0){
            return [];
        }else{
            foreach ($_return as $key => $value) {
                $type = [];
                $arrSize = [];
                $arrTopping = [];
                $data_Type = DB::table('type__products')
                    ->join('products', 'type__products.id_product', '=', 'products.id')
                    ->join('types', 'type__products.id_type', '=', 'types.id')
                    ->where('products.id',$value->id)
                    ->select('types.type_name')
                    ->get();

                if($data_Type->count() != 0){
                    foreach ($data_Type as $i => $iv) {
                        array_push($type,$iv->type_name);
                    }
                }
                $value->type = $type;                 


                $data_Size = DB::table('options')
                    ->where('options.type',1)
                    ->join('products', 'products.id', '=', 'options.id_product')
                    ->select('options.id','options.option_name','options.price_option')
                    ->where('products.id',$value->id)
                    ->get();

                if($data_Size->count() != 0){
                    foreach ($data_Size as $i => $iv) {
                        $iv->status = false;
                        array_push($arrSize,$iv);
                    }
                }
                $value->arrSize = $arrSize; 


                $data_Topping = DB::table('options')
                    ->where('options.type',0)
                    ->join('products', 'products.id', '=', 'options.id_product')
                    ->select('options.id','options.option_name','options.price_option')
                    ->where('products.id',$value->id)
                    ->get();

                if($data_Topping->count() != 0){
                    foreach ($data_Topping as $i => $iv) {
                        $iv->status = false;
                        array_push($arrTopping,$iv);
                    }
                }
                $value->arrTopping = $arrTopping;      

            }
            return $_return;
        }
    }    

    public static function get_Product($id){

        $_return = DB::table('products')->where('id_product', $id)
        ->first();

        if(empty($_return)){
            return 0;
        }else{
            $type = [];
            $arrSize = [];
            $arrTopping = [];
            $data_Type = DB::table('type__products')
                ->join('products', 'type__products.id_product', '=', 'products.id')
                ->join('types', 'type__products.id_type', '=', 'types.id')
                ->where('products.id',$_return->id)
                ->select('types.type_name')
                ->get();

            if($data_Type->count() != 0){
                foreach ($data_Type as $i => $iv) {
                    array_push($type,$iv->type_name);
                }
            }
            $_return->type = $type;                 


            $data_Size = DB::table('options')
                ->where('options.type',1)
                ->join('products', 'products.id', '=', 'options.id_product')
                ->select('options.id','options.option_name','options.price_option')
                ->where('products.id',$_return->id)
                ->get();

            if($data_Size->count() != 0){
                foreach ($data_Size as $i => $iv) {
                    $iv->status = false;
                    array_push($arrSize,$iv);
                }
            }
            $_return->arrSize = $arrSize; 


            $data_Topping = DB::table('options')
                ->where('options.type',0)
                ->join('products', 'products.id', '=', 'options.id_product')
                ->select('options.id','options.option_name','options.price_option')
                ->where('products.id',$_return->id)
                ->get();

            if($data_Topping->count() != 0){
                foreach ($data_Topping as $i => $iv) {
                    $iv->status = false;
                    array_push($arrTopping,$iv);
                }
            }
            $_return->arrTopping = $arrTopping;      
        }
        return $_return;
    } 


    public static function get_raw_Product($id){
        $value = DB::table('products')
                    ->where('id',$id)
                    ->first();
        if(isset($value)){
            return $value;
        }else{
            return 0;
        }
    }
    public static function delete_Product($id_product){
        $value= Product::get_Product($id_product);
        if(count($value) != 0){
            foreach ($value as $key => $v) {
                if(count($v->type) != 0){
                    DB::table('type__products')
                    ->where('type__products.id_product',$v->id)
                    ->delete();
                }
                if(count($v->arrTopping) != 0 || count($v->arrSize) != 0){
                    DB::table('options')
                    ->where('options.id_product',$v->id)
                    ->delete();
                }
                DB::table('products')->where('id', $v->id)->delete();
            }
            return 1;
        }else{
            return 0;
        }
    }


    public static function update_Product($request){
        $_return = DB::table('products')->where('id_product', $request->id_product)->get();
        if($_return->count() == 0){
            return 0; 
        }
        foreach ($_return as $k => $v) {
            $time_now = date("Y-m-d H:i:s");
            $product_update = [
                'id_product' => $request->id_product,
                'name_product' => $request->name_product,
                'price_product' => $request->price_product,
                'image' => $request->image,
                'description' => $request->description,
                'status' => $request->status,
                'updated_at' =>  $time_now,
            ];
            // update data on table products ///
            DB::table('products')
            ->where('id', $v->id)
            ->update($product_update);

            //update type////

            if(isset($request->type)){
                DB::table('type__products')
                ->where('type__products.id_product',$v->id)
                ->delete();
                foreach ($request->type as $i => $type) {
                    $value_insert_type = [
                        "id_product" => $v->id,
                        "id_type" => $type['id'],
                        "created_at" => $time_now,
                        "updated_at" => $time_now,
                    ];
                    DB::table('type__products')
                    ->insert($value_insert_type);
                }
            }

            // update data on table options ///

            if(isset($request->option)){
                DB::table('options')
                ->where('options.id_product',$v->id)
                ->delete();
                foreach ($request->option as $key => $value) {
                    $value_insert = [
                        "option_name" => $value['option_name'],
                        "price_option" => $value['price_option'],
                        "type" => $value['type'],
                        "id_product" => $v->id,
                        "created_at" => $time_now,
                        "updated_at" =>$time_now,
                    ];
                    DB::table('options')->insert($value_insert);
                }
            }

        }
        return 1;
    }




}
