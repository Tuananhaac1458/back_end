<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;  
class Comments extends Model
{
    //
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'value','id_new','id_user'
    ];


   //  public static function set($data){
   //      $value=DB::table('comments')
   //      ->where('id_new', $data['id_new'])
   //      ->where('id_user', $data['id_user'])
   //      ->first();
   //      if(isset($value)){
   //          $value=DB::table('likes')
			// ->where('id_new', $data['id_new'])
	  //       ->where('id_user', $data['id_user'])
	  //       ->delete($data);
   //          return 0;
   //      }
   //      $value=DB::table('likes')
   //      ->insert($data);
   //      return 1;
   //  }

	static function _renderCommnets($arrRaw)
    {
    	$_data = [];
    	foreach ($arrRaw as $key => $comment) {
    		$isComment = (object) [
    			"auther" => (object)[
    				"id" => $comment->id_user,
    				"user_name" => $comment->user_name,
    				"url_avatar" => $comment->url_avatar,
    				"point" => $comment->point,
    			],
          "id" => $comment->id,
    			"id_new" => $comment->id_new,
    			"value" => $comment->value,
    			"timestep" => $comment->updated_at,
    		];
	    	array_push($_data, $isComment);
    	}
    	return $_data;
    }

    public static function getAll_with_id_news($id_new){
    	$value = DB::table('comments')
    	->where('id_new', $id_new)
    	->join('users','users.id','=','comments.id_user')
    	->select('users.user_name','users.point','users.url_avatar','comments.id_new','comments.id_user','comments.id','comments.value', 'comments.updated_at')
      ->orderBy('updated_at', 'desc')
    	->get();
    	$dataReturn = Comments::_renderCommnets($value);
    	return $dataReturn;
    }

    public static function getPaging($id_new,$limit,$page){
    	if(empty($limit) || empty($id_new)){
            return 0;
        }
        $value=DB::table('comments')
    	   ->where('id_new', $id_new)
        ->join('users','users.id','=','comments.id_user')
        ->select('users.user_name','users.point','users.url_avatar','comments.id_new','comments.id_user','comments.id','comments.value', 'comments.updated_at')
        ->orderBy('updated_at', 'desc')
        ->offset(($page-1)*$limit)
        ->limit($limit)
        ->get();
        $dataReturn = Comments::_renderCommnets($value);
    	return $dataReturn;
    }

    public static function count_with_id_news($id_new){
      if(empty($id_new)){
            return [];
        }
      $value = DB::table('comments')
      ->where('id_new', $id_new)
      ->get();
      return $value->count();
    }
}
