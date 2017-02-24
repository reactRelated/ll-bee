<?php

namespace App\Http\Controllers\AdminApi;

use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

        /*
         * 注册*/
        public function  Register(Request $request ){
            $this->validate($request, [
                'password' => 'required|numeric',
            ]);
            $RegisterData=$request->only(['username','nickname','password','email','authority']);

            $UserRegisterInsertSQL= UserModel::$RegisterInsert["SQL"];


            $RegisterData['user_id']=autoIncrementMD5();
            $RegisterData['regdate']=currentDateTime();
            $RegisterData['password'] = md5($RegisterData['password']);

            $bol = DB::insert($UserRegisterInsertSQL,$RegisterData);


            if ($bol){
                return  response()->json(['state'=>'成功']);
            }else{
                return  response()->json(['state'=>'失败']);
            }

        }
        /*登录*/
        public function  SignIn(Request $request){
            $UserModel = new UserModel;
            $SignInData=$request->only(['username', 'password']);

             $UserData = $UserModel->userQuery($SignInData['username']);

            if(md5($SignInData['password']) === $UserData[0]->password){
                session(['username'=>$SignInData['username'] ,'password'=>$SignInData['password']]);
                return  response()->json(['state'=>'成功']);
            }else{
                return  response()->json(['state'=>'失败']);
            }

        }

}