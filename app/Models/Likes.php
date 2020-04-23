<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;  
class Likes extends Model
{
    //

    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_new','id_user'
    ];


    public static function set($data){
        $value=DB::table('likes')
        ->where('id_new', $data->id_new)
        ->where('id_user', $data->id_user)
        ->first();
        if(isset($value)){
            $value=DB::table('likes')
			->where('id_new', $data->id_new)
        	->where('id_user', $data->id_user)
	        ->delete();
            return 0;
        }
        $dataInsert = [
        	"id_new" => $data->id_new,
        	"id_user" => $data->id_user
        ];
        $value=DB::table('likes')
        ->insert($dataInsert);
        return 1;
    }


    public static function count_with_id_news($id_new){
    	if(empty($id_new)){
            return [];
        }
    	$value = DB::table('likes')
    	->where('id_new', $id_new)
    	->get();
    	return $value->count();
    }

    public static function checkIsLike($id_user,$id_new){
    	if(empty($id_new) || empty($id_user)){
            return 0;
        }
    	$value = DB::table('likes')
    	->where('id_new', $id_new)
    	->where('id_user', $id_user)
    	->first();
    	if(isset($value)){
    		return 0;
    	}
    	return 1;
    }


}
