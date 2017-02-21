<?php

namespace App\Http\Controllers\AdminApi;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
        public function  SignIn(Request $request){
            $User = new User();
            $user=$request->only(['username','password']);
             $UserData = $User->userQuery($user['username']);
            if($user['password'] == $UserData[0]['password']){
                return  response()->json(['state'=>'成功']);
            }else{
                return  response()->json(['state'=>'失败']);
            }



        }
}