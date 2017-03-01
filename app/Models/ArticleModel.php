<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/03/01
 * Time: 下午 5:17
 */

namespace App\Models;

use Illuminate\Support\Facades\DB;
class ArticleModel
{
    const table = 't_article';


    /*增*/

    static $AddArticleInsert = [
        'SQL'=> 'insert into  '.self::table.' (article_id,title,info,author,updatetime,articletype) values (:article_id,:title,:info,author,:updatetime,:articletype)'
    ];
}