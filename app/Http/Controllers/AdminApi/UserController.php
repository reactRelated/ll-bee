<?php

namespace App\Http\Controllers\AdminApi;


use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

        /*
         * 注册*/
        public function  Register(Request $request ){

            $RegisterValidationParams = Validator::make(
                $request->only(['username','nickname','password','email','authority']),
                [
                'username' => 'required',
                'nickname' => 'required',
                'password' => 'required|numeric',
                'email' => 'required|email',
                'authority' => 'required|numeric',
                ],
                [
                    'password.numeric' => '密码不正确',
                   'email.email'=> '邮箱不正确'
                ]);
            if ($RegisterValidationParams->fails()) {

                $av =response()->json(['state'=>$RegisterValidationParams->errors()]);
                return  $av;
            }

            $RegisterData=$RegisterValidationParams->getData();

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