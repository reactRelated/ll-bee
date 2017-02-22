<?php

namespace App\Http\Controllers\AdminApi;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{

        /*
         * 注册*/
        public  function  Register(Request $request){
                    $a=1;
                return "Register";
        }
        /*登录*/
        public function  SignIn(Request $request){
            $User = new User();

            $user=$request->only('username','password');
             $UserData = $User->userQuery($user['username']);
             $pa =$user['password'] ;
            if($pa== $UserData[0]->password){
                return  response()->json(['state'=>'成功']);
            }else{
                return  response()->json(['state'=>'失败']);
            }


        }
}