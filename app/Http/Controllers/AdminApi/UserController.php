<?php

namespace App\Http\Controllers\AdminApi;

use App\Common\StsCode;
use App\Models\UserModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
            //验证错误
            if ($RegisterValidationParams->fails()) {

                return  response()->json(outJson(StsCode::STATUS_SUCCESS,$RegisterValidationParams->errors()->first()));
            }

            $RegisterData=$RegisterValidationParams->getData();

            $isUserNameSame=DB::select(UserModel::$SignInSelect["SQL"],[$RegisterData['username']]);

            if($isUserNameSame){
                return  response()->json(outJson(StsCode::STATUS_ERROR,'用户已经注册'));
            }

            $UserRegisterInsertSQL= UserModel::$RegisterInsert["SQL"];


            $RegisterData['user_id']=autoIncrementMD5();
            $RegisterData['regdate']=currentDateTime();
            $RegisterData['password'] = md5($RegisterData['password']);

            $UserRegisterResult = DB::insert($UserRegisterInsertSQL,$RegisterData);


            if ($UserRegisterResult){
                return  response()->json(outJson(StsCode::STATUS_SUCCESS,'注册成功',$UserRegisterResult));
            }else{
                return  response()->json(outJson(StsCode::STATUS_ERROR,'注册失败'));
            }

        }
        /*登录*/
        public function  SignIn(Request $request){
            $SignInData=$request->only(['username', 'password']);

            $UserData=DB::select(UserModel::$SignInSelect["SQL"],[$SignInData['username']]);

            //对比是否存在
            if(md5($SignInData['password']) === $UserData[0]->password){

                session([
                    'userinfo.user_id'=>$UserData[0]->user_id,
                    'userinfo.username'=>$SignInData['username'],
                    'userinfo.password'=>md5($SignInData['password']
                    )]);

                return  response()->json(outJson(StsCode::STATUS_SUCCESS,'登录成功',$UserData[0]));
            }else{
                return  response()->json(outJson(StsCode::STATUS_ERROR,'密码错误,登录失败'));
            }



        }

        /*登出*/
        public function  SignOut(Request $request){

            session()->forget('userinfo');

            return  response()->json(outJson(StsCode::STATUS_SUCCESS,'登出成功'));

        }

}