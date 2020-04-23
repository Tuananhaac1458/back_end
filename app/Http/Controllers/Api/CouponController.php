<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Coupon_User;
use Illuminate\Http\Request;

class CouponController extends Controller
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


    public function check_With_Code(Request $request)
    {

        if(empty($request->code_coupon) || empty($request->id_user)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        if($data = Coupon::check_Coupon($request)){
            $data =  Coupon::get_Coupon_with_code($request->code_coupon);
            return response()->json([
                'status' => true,
                'data' => $data,
            ],200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Err',
        ],200);
    }



    public function add_Coupon_to_User(Request $request)
    {
        if(empty($request->id_coupon) || empty($request->id_user)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }

        if($data = Coupon::add_Coupon_to_User($request)){
            return response()->json([
                'status' => true,
                'message' => 'Sucressfull',
            ],200);
        }
        return response()->json([
            'status' => false,
            'message' => 'Err',
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

    public function add_Coupon(Request $request)
    {
        if(empty($request->code_coupon) || empty($request->type_coupon) || empty($request->value_coupon)){
            return response()->json([
                'status' => false,
                'message' => 'err',
            ],200);
        }

        $value_insert = [
            'code_coupon' => $request->code_coupon,
            'type_coupon' => $request->type_coupon,
            'value_coupon' => $request->value_coupon,
        ];

        if (isset($request->title_coupon)) {
            $value_insert['title_coupon'] = $request->title_coupon;
        }
        if (isset($request->subtitle_coupon)) {
            $value_insert['subtitle_coupon'] = $request->subtitle_coupon;
        }
        if (isset($request->condition_coupon)) {
            $value_insert['condition_coupon'] = $request->condition_coupon;
        }
        if (isset($request->expiry_day)) {
            $value_insert['expiry_day'] = $request->expiry_day;
        }
        if (isset($request->status)) {
            if($request->status == 'true'){
                $value_insert['status'] = 1;
            }else{
                $value_insert['status'] = 0;
            }
        }
        
        $_return = Coupon::add($value_insert);
        if($_return){
            $data_return = Coupon::getOne($request->code_coupon);
            return response()->json([
                'status' => true,
                'data' => $data_return,
            ],200); 
        }
        return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }


    public function getAll(Request $request)
    {
        $_return = Coupon::getAll();
        return response()->json([
                'status' => true,
                'data' => $_return,
            ],200);
    }


    public function getAll_to_user_id(Request $request)
    {
        if(empty($request->id)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        $_return = CouponController::get_All_with_id_user($request->id);
        if($_return){
            return response()->json([
                'status' => true,
                'data' => $_return,
            ],200);
        }
        return response()->json([
                'status' => true,
                'data' => [],
            ],200);
        
    }

    public static function get_All_with_id_user($id){
        $_return = Coupon_User::get_with_id_user($id);
        if($_return){
            return $_return;
        }
        return [];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        //
    }


    public function delete_Coupon(Request $request)
    {
        if(empty($request->id)){
            return response()->json([
                'status' => false,
                'message' => 'err',
            ],200);
        }
        if(Coupon::delete_Coupon($request->id)){
            return response()->json([
                'status' => true,
                'message' => 'Sucressfull',
            ],200);
        }
        return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        
    }
}
