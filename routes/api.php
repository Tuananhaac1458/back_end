<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/product', function(){
	return User::all();
});

//////login//////
Route::get('user', 'Api\UserController@login')->name('User.show');

//////register//////
Route::post('user/register', 'Api\UserController@register')->name('user.store');

//////verification//////
Route::get('user/register/verification', 'Api\UserController@verification_Phone')->name('user.verification_Phone');

// Route::get('user/find', 'Api\UserController@show')->name('user.show');
///// update name with id_user////////
Route::put('user/update/{id}', 'Api\UserController@update_User_Name')->name('user.update_User_Name');


/// check isset id social ///////
Route::post('user/upload/avatar', 'Api\UserController@upload_image')->name('user.upload_image');


///// connect social network with id_user////////
Route::put('user/connect', 'Api\UserController@connect_social')->name('user.connect_social');


/// check isset id social ///////
Route::get('user/social', 'Api\UserController@checkSocial')->name('user.checkSocial');



Route::get('user/point', 'Api\UserController@setPoint')->name('user.setPoint');



Route::put('user/address', 'Api\UserController@add_address_with_id_user')->name('user.add_address_with_id_user');


Route::get('user/address/getall', 'Api\UserController@get_Address_with_id_user')->name('user.get_Address_with_id_user');



///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Product Api//////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

//// insert type///// 
Route::post('product/type', 'Api\ProductController@insert_Type')->name('product.insert_Type');



/// get product with id ////
Route::get('product/id', 'Api\ProductController@get_Product')->name('user.get_Product');

// get all product ////
Route::get('product', 'Api\ProductController@show_Products')->name('user.show_Products');

/// insert product ///
Route::post('product', 'Api\ProductController@insert_Products')->name('product.insert_Products');

/// delete product
Route::get('product/delete', 'Api\ProductController@delete_Product')->name('user.delete_Product');

// update product ////
Route::put('product/update', 'Api\ProductController@update_Product')->name('user.update_Product');





///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////News Api//////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////



Route::post('news/insert', 'Api\NewController@insert_News')->name('news.insert_News');


Route::get('news/getall', 'Api\NewController@getAll_News')->name('news.getAll_News');


Route::get('news', 'Api\NewController@getPaging')->name('news.getPaging');


Route::get('news/detail', 'Api\NewController@getNewDetail')->name('news.getNewDetail');


Route::get('news/delete', 'Api\NewController@delete_News')->name('news.delete_News');


///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////Comments Api//////////////////////////////////////////

Route::get('news/comment/getall', 'Api\NewController@get_all_commnet_with_id_new')->name('news.get_all_commnet_with_id_new');


Route::get('news/comment/paging', 'Api\NewController@getPaging_commnet_with_id_new')->name('news.getPaging_commnet_with_id_new');


///////////////////////////////////////////////////////////////////////////////////
/////////////////////////////Like Api///////////////////////////////////////////

	
Route::get('news/like', 'Api\NewController@setLike')->name('news.setLike');
	

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Coupon Api//////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

Route::get('coupon/getAll', 'Api\CouponController@getAll')->name('coupon.getAll');


Route::get('coupon/getAll/user', 'Api\CouponController@getAll_to_user_id')->name('coupon.getAll_to_user_id');


Route::post('coupon/add', 'Api\CouponController@add_Coupon')->name('coupon.add_Coupon');


Route::get('coupon/delete', 'Api\CouponController@delete_Coupon')->name('coupon.delete_Coupon');


Route::get('coupon/check', 'Api\CouponController@check_With_Code')->name('coupon.check_With_Code');


Route::post('coupon/addtouser', 'Api\CouponController@add_Coupon_to_User')->name('coupon.add_Coupon_to_User');

///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Invoice Api//////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////


Route::post('invoice/add', 'Api\InvoiceController@add')->name('invoice.add');


Route::get('invoice/show', 'Api\InvoiceController@show_invoice_with_id')->name('invoice.show_invoice_with_id');


Route::get('invoice/show/user', 'Api\InvoiceController@getAll_with_user_id')->name('invoice.getAll_with_user_id');


Route::get('invoice/address', 'Api\InvoiceController@show_diver_money')->name('invoice.show_diver_money');


Route::get('invoice/address/store', 'Api\InvoiceController@show_diver_money_with_id_store')->name('invoice.show_diver_money_with_id_store');


///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////Store Api//////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

Route::get('store/getall', 'Api\StoreController@getAll')->name('store.getAll');


Route::post('store/add', 'Api\StoreController@add')->name('store.add');


Route::get('store/show', 'Api\StoreController@get_with_id')->name('store.get_with_id');


Route::put('store/update', 'Api\StoreController@update_with_id')->name('store.update_with_id');


Route::get('store/delete', 'Api\StoreController@delete_with_id')->name('store.delete_with_id');
