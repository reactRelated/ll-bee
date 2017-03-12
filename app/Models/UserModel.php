<?php

namespace App\Models;


use Illuminate\Support\Facades\DB;

class UserModel
{

    const table = 't_user';

    /*增*/

    static $RegisterInsert = [
        'SQL'=> 'insert into  '.self::table.' (user_id,username,nickname,password,email,authority,regdate) values (:user_id,:username,:nickname,:password,:email,:authority,:regdate)'
    ];


    /*查*/
    static $SignInSelect=[
        'SQL'=>'select * from '.self::table.' where username = ?'
    ];

    /*改*/


    static $UserAvatorUpdate=[
        'SQL'=>'update '.self::table.' set avator = :Avator,  where name = ?'
    ];

    static function UserAvatorUpdate($param){
        $a ='update '.self::table.' set avator = :avator  where user_id = :user_id';
        return DB::update('update '.self::table.' set avator = :avator  where user_id = :user_id',$param);
    }

    static function UserInfoUpdate($param){
         $updateParam="";
        $data=[
            "user_id"=>$param["user_id"]
        ];
        if(!empty($param["nickname"])){
            $updateParam .= ' nickname = :nickname,';
            $data["nickname"]=$param["nickname"];
        }
        if(!empty($param["email"])){
            $updateParam .= ' email = :email,';
            $data["email"]=$param["email"];
        }

        if(!empty($param["phone"])){
            $updateParam .= ' phone = :phone,';
            $data["phone"]=$param["phone"];
        }
        if(!empty($param["password"])){
            $updateParam .= ' password = :password,';
            $data["password"]=md5($param["password"]);
        }
        if(!empty($param["residence"])){
            $updateParam .= ' residence = :residence,';
            $data["residence"]=$param["residence"];
        }

        return DB::update('update '.self::table.' set '.chop($updateParam,",").'  where user_id = :user_id',$data);
    }

}