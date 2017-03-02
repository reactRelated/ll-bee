<?php

namespace App\Models;


class UserModel
{

    const table = 't_user';

    /*增*/

    static $RegisterInsert = [
        'SQL'=> 'insert into  '.self::table.' (user_id,username,nickname,password,email,authority,regdate) values (:user_id,:username,:nickname,:password,:email,:authority,:regdate)'
    ];

    /*查*/
    static $SignInSelect=[
        'SQL'=>'select password from '.self::table.' where username = ?'
    ];


}