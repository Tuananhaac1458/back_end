<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\CouponController;

use App\Models\Invoice;
use App\Models\Address_User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


use App\Models\User as User;
class UserController extends Controller
{

    public function upload_image(Request $request){
        if(empty($request->image) || empty($request->id)){
            return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],200);
        }
            $id_user = $request->id;
            $User = User::where('id_user',$id_user)
                    ->where('phone_verified_at', 1)
                    ->first();
            if(isset($User)){
                $image = $request->image;  // your base64 encoded
                $image = str_replace('data:image/jpg;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'public/uploads/images/'.Str::random(10).'.'.'jpg';

                Storage::put( $imageName, base64_decode($image));
                if(isset($User->url_avatar)){
                    if(strstr($User->url_avatar, '207.148.121.180')){
                        $str = 'public/'.substr($User->url_avatar, strpos($User->url_avatar,'uploads'));
                        Storage::delete($str);
                    }
                }
                $storagePath  = 'http://207.148.121.180/storage/'.substr($imageName, strpos($imageName,'uploads'));
                $userUpdate = [
                    'url_avatar' => $storagePath
                ];
                $_return = User::update_User($id_user, $userUpdate);
                if($_return){
                    $user_new = User::where('id_user',$id_user)->first();
                    return response()->json([
                        'status' => true,
                        'data' => $user_new,
                    ],200);
                }else{
                    return response()->json([
                        'status' => false,
                        'message' => 'Err',
                    ],200); 
                }
            }else{
                return response()->json([
                        'status' => false,
                        'message' => 'Err',
                    ],200);  
            }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return response()->json([
            'status' => false,
            'message' => 'Yeu cau khong hop le',
        ],206);
    }



    public function verification_Phone(Request $request)
    {
        if(isset($request->phone)){
            $user = User::where('phone_number', $request->phone)->first();
            if(isset($user)){
                User::where('phone_number', $request->phone)
                ->update(['phone_verified_at' => 1]);

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
        return response()->json([
            'status' => false,
            'message' => 'Yeu cau khong hop le',
        ],200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if(isset($request->phone_number) && isset($request->id_user)){
            $user = User::where('phone_number', $request->phone_number)
            ->first();
            if(isset($user)){
                if($user->phone_verified_at == 1){
                    return response()->json([
                        'status' => false,
                        'message' => 'User ton tai',
                    ],200);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Phone number not verified',
                ],200);
            }else{
                $user = [
                    'id_user' => $request->id_user,
                    'phone_number' => $request->phone_number,
                ];
                if(isset($request->id_social)){
                    $user['id_social'] = $request->id_social;
                }
                if(isset($request->password)){
                    $user['password'] = md5($request->password);
                }
                if(isset($request->email)){
                    $user['email'] = $request->email;
                }
                if(isset($request->user_name)){
                    $user['user_name'] = $request->user_name;
                }
                if(isset($request->url_avatar)){
                    $user['url_avatar'] = $request->url_avatar;
                }
                if(isset($request->birt_day)){
                    $user['birt_day'] = $request->birt_day;
                }
                if(isset($request->point)){
                    $user['point'] = $request->point;
                }
                if(isset($request->phone_verified_at)){
                    if($request->phone_verified_at === 'true'){
                        $user['phone_verified_at'] = 1;
                    }else{
                        $user['phone_verified_at'] = 0;
                    }
                }
                if(User::insert_User($user)){
                    return response()->json([
                        'status' => true,
                        'message' => 'Successful',
                    ],201); 
                }
                    return response()->json([
                        'status' => false,
                        'message' => 'Err',
                    ],201); 
                // User::create($user);
                // return response()->json([
                //     'status' => true,
                //     'message' => 'Successful',
                // ],201);        
            }
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],200);
        }
    }

    public function checkSocial(Request $request)
    {
        if(isset($request->id)){
            $user = User::where('id_social', $request->id)
            ->where('phone_verified_at',1)
            ->first();
            if(isset($user)){
                return response()->json([
                    'status' => false,
                    'message' => 'Account has connceted',
                ],200);
            }else{
                return response()->json([
                    'status' => true,
                    'message' => 'continue',
                ],200);
            } 
        }
        return response()->json([
            'status' => false,
            'message' => 'Yeu cau khong hop le',
        ],200);
    }


    public function connect_social( Request $request)
    {
        if(isset($request->id)){
            $user = User::where('id_user',$request->id)
            ->where('id_social',null)
            ->where('phone_verified_at',1)
            ->first();    
            if(empty($user)){
                return response()->json([
                    'status' => false,
                    'message' => 'User not exits',
                ],200);
            }
            $data_social = $request->social;
            $userUpdate = [
                'id_social' => $data_social['id'],
                'url_avatar' => $data_social['url_avatar'],
                'email' => $data_social['email'],
                'user_name' => $data_social['user_name'],
            ];
            $_return = User::update_User($request->id, $userUpdate);    
            if($_return){
                $user_new = User::where('id_user',$request->id)->get();
                return response()->json([
                    'status' => true,
                    'data' => $user_new,
                ],200);
            }else{
               return response()->json([
                    'status' => false,
                    'data' => 'Err',
                ],200); 
            }

        }
        return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //
        if(empty($request->token)){
            return response()->json([
                        'status' => false,
                        'message' => 'Err',
                    ],200);
        }
        if(isset($request->social)){
            $user = User::where('id_social', $request->social)->first();
            if(isset($user)){
                $return = [
                    "status" => true,
                    "data" => $user
                ];
                return response($return,200);
            }
            return response()->json([
                    'status' => false,
                    'message' => 'user not fond',
                ],200);
        }
        if(isset($request->p) And isset($request->pw)){
            $user = User::where('phone_number', $request->p)->first();
            if(empty($user)){
                return response()->json([
                    'status' => false,
                    'message' => 'user not fond',
                ],200);
            }
            if($user->password != md5($request->pw)){
                return response()->json([
                    'status' => false,
                    'message' => 'worrong pass or phone number',
                ],200);
            }

            if(isset($user)){
                $updateToken = [
                    "token" => $request->token,
                ];
                User::update_User($user->id_user,$updateToken);

                $coupons = CouponController::get_All_with_id_user($user->id);
                $user->coupons = $coupons;

                $invoices = Invoice::getAll_with_user_id($user->id);
                $user->invoices = $invoices;

                $address = Address_User::get_Address_with_id_user($user->id);
                $user->address = $address;

                $return = [
                    "status" => true,
                    "data" => $user
                ];
                return response($return,200);
            }
        }
        return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],200);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update_User_Name(Request $request, $id)
    {
        if(isset($id)){
            $id_user = $id;
            $user_name = $request->user_name;
            $email = $request->email;
            $user = [
                'user_name' => $user_name,
                'email' => $email,
            ];
            $_return = User::update_User($id_user, $user);    
            if($_return){
                $user_new = User::where('id_user',$id_user)->first();
                return response()->json([
                    'status' => true,
                    'data' => $user_new,
                ],200);
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'Err',
                ],200); 
            }
        }
        return response()->json([
                'status' => false,
                'message' => 'Yeu cau khong hop le',
            ],200);
    }


    public function add_address_with_id_user(Request $request)
    {
        //
        
        if(empty($request->id_user) || empty($request->longitude) || empty($request->latitude)){
            return response()->json([
                    'status' => false,
                    'message' => 'Err',
                ],200);
        }
        $datainsert = [
            "id_user" => $request->id_user,
            "type" => $request->type,
            "title" => $request->title,
            "longitude" => $request->longitude,
            "latitude" => $request->latitude,
        ];
        if (isset($request->default)) {
            $datainsert['default'] = $request->default;
        }
        if(Address_User::add($datainsert)){
            $data = Address_User::get_Address_with_id_user($request->id_user);
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


    public function get_Address_with_id_user(Request $request){
        //
        if(empty($request->id_user)){
            return response()->json([
                    'status' => false,
                    'message' => 'Err',
                ],200);
        }
        $data = Address_User::get_Address_with_id_user($request->id_user);
        return response()->json([
                    'status' => true,
                    'message' => $data,
                ],200);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $data = [];
        if(isset($request->name)){
            $data['name'] = $request->name;   
        }
        return response()->json($data,200);

    }


    public function setPoint(Request $request)
    {
        if(empty($request->id_user) || empty($request->point)){
            return response()->json([
                    'status' => false,
                    'message' => 'Err',
                ],200);
        }
        if(User::setPoint($request->id_user,$request->point)){
            return response()->json([
                    'status' => true,
                    'message' => 'Congratulations',
                ],200);
        }else{
            return response()->json([
                    'status' => false,
                    'message' => 'Err',
                ],200);
        }
         
    }
        

}
