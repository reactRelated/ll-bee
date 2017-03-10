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
        'SQL'=> 'insert into  '.self::table.' (article_id,title,info,author,updatetime,classify) values (:article_id,:title,:info,:author,:updatetime,:classify)'
    ];

    /*查*/
    static $ArticleListSelect = [
        'SQL'=> 'select * from '.self::table
    ];


    static function doQueryArticleList($param){
        $sql_where = " where 1=1";
        $data=[];
        if(!empty($param["title"])){
           $sql_where = $sql_where.' and title like :title';
            $data["title"]='%'.$param["title"].'%';
        }

        if(!empty($param["classify"])){
            $sql_where = $sql_where.' and classify like :classify';
            $data["classify"]='%'.$param["classify"].'%';
        }

        if(!empty($param["author"])){
            $sql_where = $sql_where.' and author like :author';
            $data["author"]='%'.$param["author"].'%';
        }

        if(!empty($param["updatetime"])){
            $sql_where = $sql_where.' and updatetime like :updatetime';
            $data["updatetime"]='%'.$param["updatetime"].'%';
        }

        return DB::select(self::$ArticleListSelect['SQL'].$sql_where,$data);


    }
}