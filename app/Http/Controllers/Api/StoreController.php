<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
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


    public function getAll()
    {
        $data = Store::getAll();
        return response()->json([
                'status' => true,
                'data' => $data,
            ],200);
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

    public function add(Request $request)
    {
        if(empty($request->image) || empty($request->address) || empty($request->longitude) || empty($request->latitude)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        $dataInsert = [
            "image" => $request->image,
            "address" => $request->address,
            "longitude" => $request->longitude,
            "latitude" => $request->latitude,
            "style" => $request->style,
            "numberPhone" => $request->numberPhone,
            "timeOpen" => $request->timeOpen,
            "timeClose" => $request->timeClose,
            "status" => $request->status,
        ];
        if(Store::add($dataInsert)){
            $data = Store::get_latest();
            return response()->json([
                'status' => true,
                'data' => $data,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
    }    



    public function get_with_id(Request $request){
        if(empty($request->id)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        $data = Store::get_with_id($request->id);
        if($data){
            return response()->json([
                'status' => true,
                'data' => $data,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'not found',
            ],200);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    public function update_with_id(Request $request)
    {
        if(empty($request->id) || empty($request->address) || empty($request->longitude) || empty($request->latitude)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        $dataInsert = [
            "image" => $request->image,
            "address" => $request->address,
            "longitude" => $request->longitude,
            "latitude" => $request->latitude,
            "style" => $request->style,
            "numberPhone" => $request->numberPhone,
            "timeOpen" => $request->timeOpen,
            "timeClose" => $request->timeClose,
            "status" => $request->status,
        ];
        if(Store::update_with_id($request->id,$dataInsert)){
            $data = Store::get_with_id($request->id);
            return response()->json([
                'status' => true,
                'data' => $data,
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        //
    }

    public function delete_with_id(Request $request){
        if(empty($request->id)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        $data = Store::delete_with_id($request->id);
        if($data){
            return response()->json([
                'status' => true,
                'message' => 'done!',
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
    }
}
