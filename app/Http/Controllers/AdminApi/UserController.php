<?php

namespace App\Http\Controllers\AdminApi;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Session\Session;
class UserController extends Controller
{

        /*
         * 注册*/
        public  function  Register(Request $request){

            $SignInData=$request->only(['username','password']);

        }
        /*登录*/
        public function  SignIn(Request $request){
            $UserModel = new UserModel;
            $SignInData=$request->only(['username', 'password']);
            $SignInData1=$request->get("username");
            $SignInData2=$request->input('user.username');
            $SignInData3=$request->all();
             $UserData = $UserModel->userQuery($SignInData['username']);

            if(md5($SignInData['password']) === $UserData[0]->password){
                session(['username'=>$SignInData['username'] ,'password'=>$SignInData['password']]);
                $site = session('username');
                return  response()->json(['state'=>'成功']);
            }else{
                return  response()->json(['state'=>'失败']);
            }

        }

}