<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/03/02
 * Time: 下午 4:15
 */

namespace App\Models;


class FK_UserArticleModel
{

    const table = 'fk_user_article';
    static $FK_UserArticleInsert = [
        'SQL'=> 'insert into  '.self::table.' (user_article_id,user_id,article_id) values (:user_article_id,:user_id,:article_id)'
    ];
}