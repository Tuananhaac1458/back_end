<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Comments;
use App\Models\Likes;
use Illuminate\Http\Request;

class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function insert_News(Request $request)
    {
        //
        if(empty($request->title_news) || empty($request->subtitle_news) || empty($request->type) || empty($request->thubnail_news) || empty($request->status) || empty($request->id_auth)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        if(News::insert_News($request)){
            return response()->json([
                'status' => true,
                'message' => 'Successful',
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }


    public function getAll_News(){
        $data = News::getAll();
        $_return = [
            "status" => true,
            "data" => $data
        ];

        return response()->json($_return,200); 
    }



    public function getPaging(Request $request){
        if(empty($request->limit) || empty($request->id_user)){
            return response()->json([
                "data" => []
            ],200); 
        }
        if(empty($request->page)){
            $data = News::getPaging($request->id_user,$request->limit,1);
        }else{
            $data = News::getPaging($request->id_user,$request->limit,$request->page);
        }
        $_return = [
            "status" => true,
            "data" => $data
        ];
        return response()->json($_return,200); 
    }


    public function getNewDetail(Request $request){
        if(empty($request->id)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        $data = News::getNewDetail($request->id);
        $_return = [
            "status" => true,
            "data" => $data
        ];

        return response()->json($_return,200); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */

    public function delete_News(Request $response){
        if(empty($response->id)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }

        if(News::delete_News($response->id)){
            return response()->json([
                'status' => true,
                'message' => 'Successful',
            ],200);
        }
        return response()->json([
                'status' => false,
                'message' => 'err',
            ],200);
    }

    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    //////////////////Commnets/////////////////////
    ///////////////////////////////////////////////

    public function get_all_commnet_with_id_new(Request $response)
    {
        if(empty($response->id_new)){
            return response()->json([
                'status' => false,
                'message' => 'err',
            ],200);
        }
        $data =  Comments::getAll_with_id_news($response->id_new);
        
        return response()->json([
                'status' => true,
                'data' => $data,
            ],200);
    }


    public function getPaging_commnet_with_id_new(Request $response)
    {
        if(empty($response->id_new) || empty($response->limit) || empty($response->page)){
            return response()->json([
                'status' => false,
                'data' => [],
            ],200);
        }
        $data =  Comments::getPaging($response->id_new,$response->limit,$response->page);
        return response()->json([
                'status' => true,
                'data' => $data,
            ],200);
    }

    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////


    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ////////////////Like//////////////////////
    ///////////////////////////////////////////////
    public function setLike(Request $response)
    {
        if(empty($response->id_new) || empty($response->id_user)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }

        if(Likes::set($response)){
            return response()->json([
                'status' => true,
                'message' => 'Liked',
            ],200);
        }
        return response()->json([
                'status' => true,
                'message' => 'Dislike',
            ],200);
    }


    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////
    ///////////////////////////////////////////////

    public function destroy(News $news)
    {
        //
    }
}
