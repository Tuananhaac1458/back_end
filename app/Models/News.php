<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Models\Contents_News;
use App\Models\Likes;
use App\Models\Comments;


use Illuminate\Support\Facades\DB;  

class News extends Model
{
    //
 	use Notifiable;


    protected $fillable = [
       'title_news','subtitle_news','thubnail_news','type','like','status','id_auth','id_news'
    ];


	public static function getAll(){
        $value=DB::table('news')
        ->select('news.id','news.title_news','news.subtitle_news','news.thubnail_news','news.type','news.isComment','news.isShare','news.updated_at','users.id_user','users.user_name','users.url_avatar')
        ->join('users','news.id_auth','=','users.id')
        ->get();
        if($value->count() != 0){
            $datareturn = [];
            foreach ($value as $key => $data) {
                $likeCount = Likes::count_with_id_news($data->id);
                $commentCount = Comments::count_with_id_news($data->id);

                $showData = (object) [
                    'head' => (object)[
                        'auth' => (object)[
                            'id_user' => $data->id_user,
                            'user_name' => $data->user_name,
                            'url_avatar' =>  $data->url_avatar,
                        ],
                        'id' => $data->id,
                        'title_news' => $data->title_news,
                        'subtitle_news' => $data->subtitle_news,
                        'thubnail_news' => $data->thubnail_news,
                        'updated_at' => $data->updated_at,
                        'type' => $data->type,

                    ],
                    'footer' => (object)[
                        'likes' => $likeCount,
                        'comments' => $commentCount,
                        'isComment' => $data->isComment,
                        'isShare' => $data->isShare,
                    ],
                ];
                array_push($datareturn,$showData);
            }
            return $datareturn;
        }else{
            return [];
        }
    }	  	


    public static function getPaging($id_user,$limit,$page){
        if(empty($limit) || empty($id_user)){
            return [];
        }
        if(empty($page)){
            $value=DB::table('news')
            ->select('news.id','news.title_news','news.subtitle_news','news.thubnail_news','news.type','news.isComment','news.isShare','news.updated_at','users.id_user','users.user_name','users.url_avatar')
            ->join('users','news.id_auth','=','users.id')
            ->limit($limit)
            ->get();
            if($value->count() != 0){
                $datareturn = [];
                foreach ($value as $key => $data) {
                    $likeCount = Likes::count_with_id_news($data->id);
                    $commentCount = Comments::count_with_id_news($data->id);
                        
                    $isLike = Likes::checkIsLike($id_user,$data->id);
                    $showData = (object) [
                        'head' => (object)[
                            'auth' => (object)[
                                'id_user' => $data->id_user,
                                'user_name' => $data->user_name,
                                'url_avatar' =>  $data->url_avatar,
                            ],
                            'id' => $data->id,
                            'title_news' => $data->title_news,
                            'subtitle_news' => $data->subtitle_news,
                            'thubnail_news' => $data->thubnail_news,
                            'updated_at' => $data->updated_at,
                            'type' => $data->type,

                        ],
                        'footer' => (object)[
                            'isLike' => $isLike,
                            'comments' => $commentCount,
                            'likes' => $likeCount,
                            'isComment' => $data->isComment,
                            'isShare' => $data->isShare,
                        ],
                    ];
                    array_push($datareturn,$showData);
                }
                return $datareturn;
            }else{
                return [];
            }
        }
        $value=DB::table('news')
        ->select('news.id','news.title_news','news.subtitle_news','news.thubnail_news','news.type','news.isComment','news.isShare','news.updated_at','users.id_user','users.user_name','users.url_avatar')
        ->join('users','news.id_auth','=','users.id')
        ->offset(($page-1)*$limit)
        ->limit($limit)
        ->get();
        if($value->count() != 0){
            $datareturn = [];
            foreach ($value as $key => $data) {
                $likeCount = Likes::count_with_id_news($data->id);
                $commentCount = Comments::count_with_id_news($data->id);
                        
                $isLike = Likes::checkIsLike($id_user,$data->id);
                $showData = (object) [
                    'head' => (object)[
                        'auth' => (object)[
                            'id_user' => $data->id_user,
                            'user_name' => $data->user_name,
                            'url_avatar' =>  $data->url_avatar,
                        ],
                        'id' => $data->id,
                        'title_news' => $data->title_news,
                        'subtitle_news' => $data->subtitle_news,
                        'thubnail_news' => $data->thubnail_news,
                        'updated_at' => $data->updated_at,
                        'type' => $data->type,

                    ],
                    'footer' => (object)[
                        'isLike' => $isLike,
                        'comments' => $commentCount,
                        'likes' => $likeCount,
                        'isComment' => $data->isComment,
                        'isShare' => $data->isShare,
                    ],
                ];
                array_push($datareturn,$showData);
            }
            return $datareturn;
        }else{
            return [];
        }
    }


    public static function getNewDetail($id){
      

        $value=DB::table('news')
        ->where('news.id',$id)
        ->join('users','news.id_auth','=','users.id')
        ->select('news.id','news.title_news','news.subtitle_news','news.thubnail_news','news.type','news.isComment','news.isShare','news.updated_at','users.id_user','users.user_name','users.url_avatar')
        ->first();
        if(isset($value)){
            ///// reder head//////
            $showData = (object) [
                'head' => (object)[
                    'auth' => (object)[
                        'id_user' => $value->id_user,
                        'user_name' => $value->user_name,
                        'url_avatar' =>  $value->url_avatar,
                    ],
                    'id' => $value->id,
                    'title_news' => $value->title_news,
                    'subtitle_news' => $value->subtitle_news,
                    'thubnail_news' => $value->thubnail_news,
                    'updated_at' => $value->updated_at,
                    'type' => $value->type,

                ],
            ];

            ///// reder body//////

            $body = [];
            $bodyValue=DB::table('contents__news')
            ->where('contents__news.id_news',$id)
            ->orderBy('part', 'asc')
            ->get();
            foreach ($bodyValue as $key => $part) {
                $showbody = (object) [
                    "title_content" => $part->title_content,
                    "thubnail_content" => $part->thubnail_content,
                    "url_content" => $part->url_content,
                    "text_content" => $part->text_content,
                    "type" => $part->type,
                    "part" => $key,
                ];
                array_push($body,$showbody);
            }
            $showData->body = $body;


            ///// reder footer//////
            $showData->footer = (object)[
                    'isComment' => $value->isComment,
                    'isShare' => $value->isShare,
                    
                ];
            return $showData;
        }else{
            return [];
        }
    }    


  	public static function insert_News($data){
        if(empty($data['id_auth']) || empty($data['id_news'])){
            return 0;
        }
        $value=DB::table('news')
        ->where('id_news', $data['id_news'])
        ->get();
        if($value->count() == 0){
            $time_now = date("Y-m-d H:i:s");
            $data_insert = [
                "id_news" => $data['id_news'],
            	"title_news" => $data['title_news'],
            	"subtitle_news" => $data['subtitle_news'],
            	"thubnail_news" => $data['thubnail_news'],
                "id_auth" => $data['id_auth'],
            	"type" => $data['type'],
            	"created_at" => $time_now,
            	"updated_at" => $time_now,
            ];
            if($data['status'] == 'true'){
            	$data_insert['status'] = 1;
            }else{
            	$data_insert['status'] = 0;
            }
            if($data['isComment'] == 'true'){
                $data_insert['isComment'] = 1;
            }else{
                $data_insert['isComment'] = 0;
            }
            if($data['isShare'] == 'true'){
                $data_insert['isShare'] = 1;
            }else{
                $data_insert['isShare'] = 0;
            }	
            DB::table('news')->insert($data_insert);

            $inserCurren=DB::table('news')
            ->where('id_news', $data['id_news'])
            ->first();
            foreach ($data['contents'] as $key => $value) {
                $value['id_news'] = $inserCurren->id;
                Contents_News::insert_Contents_News($value);
            }
            return 1;
        }else{
            return 0;
        }
    }



    public static function delete_News($id){
        $value=DB::table('news')
        ->where('news.id_news',$id)
        ->first();

        if(isset($value)){
            DB::table('contents__news')
                ->where('contents__news.id_news',$value->id)
                ->delete();
            DB::table('news')->where('id', $value->id)->delete();
            return 1;
        }else{
            return 0;
        }
    }



    public static function update_News($data){
        $value=DB::table('news')
        ->where('id', $data['id'])
        ->get();
        if($value->count() == 0){
            $time_now = date("Y-m-d H:i:s");
            $data_insert = [
            	"title_news" => $data['title_news'],
                "subtitle_news" => $data['subtitle_news'],
                "thubnail_news" => $data['thubnail_news'],
                "type" => $data['type'],
                "updated_at" => $time_now,
            ];
            if($data['status'] == 'true'){
            	$data_insert['status'] =1;
            }else{
            	$data_insert['status'] =0;
            }
            DB::table('news')
            ->where('id', $data->id)
            ->update($data_insert);
            return 1;
        }else{
            return 0;
        }
    }



}
