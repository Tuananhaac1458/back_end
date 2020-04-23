<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;  

class Store extends Model
{

	 //
    use Notifiable;

	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image','address','style', 'longitude', 'latitude','numberPhone','timeOpen','timeClose','status'
    ];



    public static function add($data){
    	if (empty($data['image']) || empty($data['address']) || empty($data['longitude']) || empty($data['latitude']) || empty($data['numberPhone'])) {
    		return 0;
    	}
        $value=DB::table('stores')
        ->where('longitude', $data['longitude'])
        ->where('latitude', $data['latitude'])
        ->first();
        if(isset($value)){
            return 0;
        }else{
        	$time_now = date("Y-m-d H:i:s");
            $data['created_at'] = $time_now;
            $data['updated_at'] = $time_now;

        	$value=DB::table('stores')
        	->insert($data);
        }
        return 1;
    }


    public static function getAll(){
        $value=DB::table('stores')
        ->get();
        return $value;
    }

    public static function get_latest(){
        $value = DB::table('stores')
                ->latest()
                ->first();
        return $value;
    }


    public static function get_with_id($id){
        $value = DB::table('stores')
        		->where('id', $id)
                ->first();
        if(isset($value)){
        	return $value;
        }else{
        	return 0;
        }
    }


    public static function update_with_id($id,$data){
    	if (empty($id)) {
    		return 0;
    	}
        $value=DB::table('stores')
        ->where('id', $id)
        ->first();

        if(isset($value)){
        	$time_now = date("Y-m-d H:i:s");
            $data['updated_at'] = $time_now;
        	DB::table('stores')
            ->where('id', $id)
            ->update($data);
        	return 1;
        }
        	return 0;
    }


    public static function delete_with_id($id){
    	if (empty($id)) {
    		return 0;
    	}
        $value=DB::table('stores')
        ->where('id', $id)
        ->delete();
        return 1;
    }



}
