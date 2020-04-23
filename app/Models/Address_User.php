<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;  

class Address_User extends Model
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
        'type','default','id_user', 'longitude', 'latitude','title'
    ];


    public static function add($data){
    	if (empty($data['id_user']) || empty($data['type'])) {
    		return 0;
    	}
        $value=DB::table('address__users')
        ->where('id_user', $data['id_user'])
        ->get();
        foreach ($value as $key => $address) {
            if($data['default']){
                DB::table('address__users')
                ->where('id',$address->id)
                ->where('type','<>',$data['type'])
                ->update([
                    'default' => false
                ]);
            }
        }
        $value2=DB::table('address__users')
        ->where('id_user', $data['id_user'])
        ->where('type', $data['type'])
        ->first();
        if(isset($value2)){
            DB::table('address__users')
            ->where('id',$value2->id)
        	->update($data);
        }else{
        	DB::table('address__users')
        	->insert($data);
        }
        return 1;
    }



    public static function get_Address_with_id_user($id){
    	if (empty($id)) {
    		return [];
    	}
        $value=DB::table('address__users')
        ->where('id_user', $id)
        ->get();
        if($value->count() > 0){
            return $value;
        }else{
        	return [];
        }
    }


	public static function delete_Address_with_id_user($id){
    	if (empty($id)) {
    		return 0;
    	}
        $value=DB::table('address__users')
        ->where('id', $id)
        ->delete();
        return 1;
    }    

}
