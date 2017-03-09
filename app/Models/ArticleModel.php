<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/03/01
 * Time: 下午 5:17
 */

namespace App\Models;

class ArticleModel
{
    const table = 't_article';


    /*增*/

    static $AddArticleInsert = [
        'SQL'=> 'insert into  '.self::table.' (article_id,title,info,author,updatetime,classify) values (:article_id,:title,:info,:author,:updatetime,:classify)'
    ];

    /*查*/
    static $ArticleListSelect = [
        'SQL'=> 'select * from '.self::table
    ];
}