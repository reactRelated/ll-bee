<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class User
{
    public function userQuery($name)
    {
        $userData = DB::select('select password from t_user where user_name = ?', [$name]);
        return $userData;
    }
}