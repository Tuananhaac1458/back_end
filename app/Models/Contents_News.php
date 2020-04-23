<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;  
class Contents_News extends Model
{
    //
    use Notifiable;


    protected $fillable = [
       'title_content','thubnail_content','url_content','text_content','type','part','id_news'
    ];


    public static function getAll(){
        $value=DB::table('contents__news')
        ->select('contents__news.title_content','contents__news.thubnail_content','contents__news.url_content','contents__news.text_content','contents__news.type','contents__news.part','contents__news.id_news')
        ->get();
        if($value->count() != 0){
            return $value;
        }else{
            return [];
        }
    }

    public static function insert_Contents_News($data){
	    	if(empty($data['id_news'])){
	            return 0;
	        }
            $data_insert = [
                "id_news" => $data['id_news'],
            ];
            if(isset($data['title_content'])){
            	$data_insert['title_content'] = $data['title_content'];
            }
            if(isset($data['thubnail_content'])){
            	$data_insert['thubnail_content'] = $data['thubnail_content'];
            }
            if(isset($data['url_content'])){
            	$data_insert['url_content'] = $data['url_content'];
            }
            if(isset($data['text_content'])){
            	$data_insert['text_content'] = $data['text_content'];
            }
            if(isset($data['type'])){
            	$data_insert['type'] = $data['type'];
            }
            if(isset($data['part'])){
            	$data_insert['part'] = $data['part'];
            }
            DB::table('contents__news')->insert($data_insert);
            return 1;
    }


    public static function delete_Contents_News($data){
        $value=DB::table('contents__news')
        ->where('id', $data['id'])
        ->get();
        if($value->count() == 0){
            DB::table('contents__news')->where('id', $data->id)->delete();
            return 1;
        }else{
            return 0;
        }
    }
}
