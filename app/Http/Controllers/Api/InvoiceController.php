<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Coupon;
use App\Models\Invoice_Product;
use App\Models\Product;
use App\Models\Store;
use App\Models\Option_Product_invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
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
    

    function choose_Store($longitude, $latitude){
        // $arr = explode("@", trim($address_value_invoice));
        $longitude = $longitude;
        $latitude = $latitude;
        $Stores = Store::getAll();
        $rangeF = 999999999;
        $storeSelect = null;
        foreach ($Stores as $key => $store) {
            $ASBlongitude = abs($store->longitude - $longitude);
            $ASBlatitude = abs($store->latitude - $latitude);
            $range = sqrt(pow($ASBlongitude,2) + pow($ASBlatitude,2));
            if($range < $rangeF){
                $rangeF = $range;
                $storeSelect = $store;
            }
        }

        $range = $rangeF * 100;
        if($range < 3){
            $money_driver = 15000;
        }else{
            $money_driver = round($range * 5000, -3);
        }
        $_return = (object)[
            'range' => round($range, 4),
            'id_store' => $storeSelect->id,
            'money_driver' => $money_driver
        ];
        return $_return;
    }


    public function show_diver_money(Request $request)
    {
        if(empty($request->longitude) || empty($request->latitude)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        $data = InvoiceController::choose_Store($request->longitude, $request->latitude);
        return response()->json([
                'status' => true,
                'data' => $data,
            ],200);
    }


    public function show_diver_money_with_id_store(Request $request)
    {
        if(empty($request->longitude) || empty($request->latitude) || empty($request->id_store)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        $store = Store::get_with_id($request->id_store);
        if($store){
            $ASBlongitude = abs($store->longitude - $request->longitude);
            $ASBlatitude = abs($store->latitude - $request->latitude);
            $range = sqrt(pow($ASBlongitude,2) + pow($ASBlatitude,2))* 100;  
            
                if($range < 3){
                    $money_driver = 15000;
                }else{
                    $money_driver = round($range * 5000, -3);
                }
                $_return = (object)[
                    'range' => round($range, 4),
                    'id_store' => $request->id_store,
                    'money_driver' => $money_driver
                ];
                return response()->json([
                    'status' => true,
                    'data' => $_return,
                ],200);
        }

        return response()->json([
                    'status' => false,
                    'message' => 'Err',
                ],200);
    }

    public function add(Request $request){
        if(empty($request->code_invoice) || empty($request->id_user) || empty($request->product) || empty($request->id_store)){
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }
        $dataInsert = [
            "code_invoice" => $request->code_invoice,
            "id_user" => $request->id_user,
            "userName_invoice" => $request->userName_invoice,
            "userPhone_invoice" => $request->userPhone_invoice,
            "address_invoice" => $request->address_invoice,
            "totalMonney" => $request->totalMonney,
            "realMoney" => $request->realMoney,
            "money_driver" => $request->money_driver,
            "status" => $request->status,
        ];
           
        if(isset($request->address_value_invoice)){
            $dataInsert['address_value_invoice'] = $request->address_value_invoice;
        }
        if(isset($request->id_coupon)){
            $dataInsert['id_coupon'] = $request->id_coupon;
        }
        if(isset($request->noteStaff_invoice)) {
            $dataInsert['noteStaff_invoice'] = $request->noteStaff_invoice;
        }
        if(isset($request->noteDriver_invoice)) {
            $dataInsert['noteDriver_invoice'] = $request->noteDriver_invoice;
        }
        if(isset($request->id_store)) {
            $dataInsert['id_store'] = $request->id_store;
        }
        if(Invoice::add($dataInsert)){
            $dataReturn = Invoice::get_with_id($request->code_invoice);
            if(isset($request->product)){
                foreach ($request->product as $key => $value) {
                    $Invoice_Product = (object) [
                        "id_invoice" => $dataReturn->id,
                        "id_product" => $value['id_product'],
                        "id_product_invoice" => $value['id_product_invoice'],
                        "amount" => $value['amount'],
                    ];
                    Invoice_Product::add($Invoice_Product);
                    if(isset($value['option'])){
                        foreach ($value['option'] as $k => $option) {
                            $Option_Product_invoice = (object) [
                                "option_name" => $option['option_name'],
                                "price_option" => $option['price_option'],
                                "id_invoice" => $dataReturn->id,
                                "id_product" => $value['id_product'],
                                "id_product_invoice" => $value['id_product_invoice']
                            ];
                            if($option['type'] == 'true'){
                                $Option_Product_invoice->type = 1; 
                            }else{
                                $Option_Product_invoice->type = 0; 
                            }
                        
                            Option_Product_invoice::add($Option_Product_invoice);
                        }
                    }
                }
            }    
            $dataReturn = InvoiceController::get_with_id_invoice($request->code_invoice);
            return response()->json([
                'status' => true,
                'data' => $dataReturn,
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
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    function get_with_id_invoice($code_invoice){
        $dataReturn = Invoice::get_with_id($code_invoice);

        $Invoice_Product = Invoice_Product::get_invoice_product_with_id($dataReturn->id);
        
        $products = [];
        foreach ($Invoice_Product as $key => $Product) {
            $product = Product::get_raw_Product($Product->id_product);
            $producta = (object)[
                "id_product" => $product->id_product,
                "name_product" => $product->name_product,
                "image" => $product->image,
                "price_product" => $product->price_product,
                "amount" => $Product->amount,
            ];

            $request_Option_Product_invoice = (object)[
                "id_invoice" => $Product->id_invoice,
                "id_product" => $product->id,
                "id_product_invoice" => $Product->id_product_invoice
            ];
            $Option_Product_invoice = Option_Product_invoice::get_with_id_invoice_product($request_Option_Product_invoice);
            if($Option_Product_invoice){
                $options = [];
                foreach ($Option_Product_invoice as $k => $Option) {
                    $option = (object)[
                        "option_name" => $Option->option_name,
                        "price_option" => $Option->price_option,
                        "type" => $Option->type,
                    ];
                    array_push($options,$option);                    
                }
                $producta->option = $options;
            }
            array_push($products,$producta);                    
        }
        $dataReturn->product = $products;

        return  $dataReturn;
    }

    public function show_invoice_with_id(Request $request)
    {
        //
        if (empty($request->code_invoice)) {
            # code...
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }

        $dataReturn = InvoiceController::get_with_id_invoice($request->code_invoice);
        return response()->json([
                'status' => true,
                'data' => $dataReturn,
            ],200);
    }


    public function getAll_with_user_id(Request $request)
    {
        if (empty($request->id)) {
            return response()->json([
                'status' => false,
                'message' => 'Err',
            ],200);
        }

        $dataReturn = Invoice::getAll_with_user_id($request->id);
        return response()->json([
                'status' => true,
                'data' => $dataReturn,
            ],200);
    }


    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
