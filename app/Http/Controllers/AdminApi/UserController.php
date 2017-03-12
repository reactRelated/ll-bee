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
        public function  SignOut(){

            session()->forget('userinfo');

            return  response()->json(outJson(StsCode::STATUS_SUCCESS,'登出成功'));

        }
        /*获取用户信息*/
        public function GetUserInfo()
        {
            $UserData=DB::select(UserModel::$SignInSelect["SQL"],[session('userinfo.username')]);

            $UserData[0]->avator=httpHost().$UserData[0]->avator;
          return  response()->json(outJson(StsCode::STATUS_SUCCESS,'查询成功',$UserData[0]));
        }

        /*编辑用户信息*/
        public function EditUserInfo(Request $request){
            $EditUserInfoParam=$request->all();

            $EditUserInfoRes=UserModel::UserInfoUpdate($EditUserInfoParam);

            if($EditUserInfoRes){
                return  response()->json(outJson(StsCode::STATUS_SUCCESS,'更新成功',$EditUserInfoRes));
            } else{
                return  response()->json(outJson(StsCode::STATUS_ERROR,'更新失败'));
            }
        }
        /*头像编辑*/
        public function EditUserAvatar(Request $request){


            //判断请求中是否包含name=file的上传文件
            if(!$request->hasFile('file')){
                return  response()->json(outJson(StsCode::STATUS_ERROR,'上传头像为空'));
            }
            $file = $request->file('file');
            //判断文件上传过程中是否出错
            if(!$file->isValid()){
                return  response()->json(outJson(StsCode::STATUS_ERROR,'头像上传出错'));
            }
            $destPath = realpath(public_path('pictureStorage'._DS_.'avatat'));
            $avatatPath = 'pictureStorage'._DS_.'avatat';

            if(!file_exists($destPath)){
                $destPath=public_path($avatatPath);
                mkdir($destPath,0755,true);
            }

            $filename = 'img'.currentDateTime("_Y.m.d_H.i.s_").$file->getClientOriginalName();

            if(!$file->move($destPath,$filename)){
                return  response()->json(outJson(StsCode::STATUS_ERROR,'头像保存失败'));
            }
            //转换成真实路径
            $avatatImg=str_replace("\\","/" ,_DS_.$avatatPath._DS_.$filename) ;

            if(UserModel::UserAvatorUpdate([
                "user_id"=>session("userinfo.user_id"),
                "avator"=>$avatatImg
            ])){
                return  response()->json(outJson(StsCode::STATUS_SUCCESS,'头像上传成功'));
            }else{
                return  response()->json(outJson(StsCode::STATUS_ERROR,'头像数据库保存失败'));
            }

        }



}