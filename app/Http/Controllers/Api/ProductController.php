<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product as Product;
use App\Models\Type as Type;
use App\Models\Option as Option;
use App\Models\Type_Product as Type_Product;


use Illuminate\Http\Request;
use Illuminate\Http\Response;


class ProductController extends Controller
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
    public function insert_Products(Request $request)
    {

        //
        if(empty($request->id_product) || empty($request->name_product) || empty($request->price_product) || empty($request->image) || empty($request->description) || empty($request->type)){
            return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],206); 
        }
        $product = Product::where('id_product', $request->id_product)->first();        
        if(isset($product)){
            return response()->json([
                'status' => false,
                'message' => 'Product exits',
            ],200); 
        }
        $product_insert = [
            'id_product' => $request->id_product,
            'name_product' => $request->name_product,
            'price_product' => $request->price_product,
            'image' => $request->image,
            'description' => $request->description,
            'status' => $request->status,
        ];
        Product::create($product_insert);

        $product_insert = Product::where('id_product', $request->id_product)->first();        

        foreach ($request->type as $key => $value) {
            $value_insert = [
                "id_product" => $product_insert->id,
                "id_type" => $value['id']
            ];
            Type_Product::create($value_insert);
        }
        if(isset($request->option)){
            foreach ($request->option as $key => $value) {
                $value_insert = [
                    "option_name" => $value['option_name'],
                    "price_option" => $value['price_option'],
                    "type" => $value['type'],
                    "id_product" => $product_insert->id,
                ];
                Option::create($value_insert);

            }
        }
        return response()->json([
                'status' => true,
                'message' => 'insert done',
            ],200);
    }




    //////////////////////// function create type /////////////////


    public function insert_Type(Request $request)
    {
        if(empty($request->type_name)){
            return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],206); 
        }
        $type = Type::where('type_name', $request->type_name)->first();
        if(isset($type)){
            return response()->json([
                'status' => false,
                'message' => 'Type exits',
            ],200); 
        }
        $type_insert = [
            'type_name' => $request->type_name
        ];
        Type::create($type_insert);
        return response()->json([
                'status' => true,
                'message' => 'insert done',
            ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }


    public function show_Products()
    {
        $Products = Product::getAll();
        $data = [
            "status" => true,
            "data" => $Products
        ];

        return response()->json($data,200);
    }

    public function get_Product(Request $request){
        if(empty($request->id)){
            return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],206); 
        }
        $Products = Product::get_Product($request->id);
        $data = [
            "status" => false,
            "data" => 'not font'
        ];

        if($Products){
            $data = [
                "status" => true,
                "data" => $Products
            ];
        }
        return response()->json($data,200);
    }





    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    public function update_Product(Request $request)
    {   
        //
        if(empty($request->id_product) || empty($request->name_product) || empty($request->price_product) || empty($request->image) || empty($request->description) || empty($request->type)){
            return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],206); 
        }

        $product = Product::where('id_product', $request->id_product)->first();        
        if(empty($product)){
            return response()->json([
                'status' => false,
                'message' => 'Product not exits',
            ],200); 
        }
        if(Product::update_Product($request)){
            return response()->json([
                'status' => true,
                'message' => 'Successful',
            ],200);
        }   
        return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200); 

    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function delete_Product(Request $product_id){
        if(empty($product_id->id)){
            return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],206); 
        }
        if(Product::delete_Product($product_id->id)){
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
}
