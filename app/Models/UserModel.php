<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class UserModel
{

    private $table = 't_user';

    /*增*/

    static $RegisterInsert = array(
        'SQL'=> 'insert into  t_user (user_id,username,nickname,password,email,authority,regdate) values (:user_id,:username,:nickname,:password,:email,:authority,:regdate)'
    );

    /*查*/
    public function userQuery($name)
    {
        $userData = DB::select('select password from t_user where user_name = ?', [$name]);
        return $userData;
    }


}