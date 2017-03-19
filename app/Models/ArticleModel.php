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
        'SQL'=> 'select * from '.self::table .' inner join t_classify on t_article.classify = t_classify.classify_id'
    ];


    static function doQueryArticleList($param){
        $sql_where = [];
        $data=[];
        if(!empty($param["title"])){

            array_push($sql_where,'title like :title');
            $data["title"]='%'.$param["title"].'%';
        }

        if(!empty($param["classifyname"])){
            array_push($sql_where,'classifyname like :classifyname');
            $data["classifyname"]='%'.$param["classifyname"].'%';
        }

        if(!empty($param["author"])){
            array_push($sql_where,'author like :author');
            $data["author"]='%'.$param["author"].'%';
        }

        if(!empty($param["updatetime"])){
            array_push($sql_where,'updatetime like :updatetime');
            $data["updatetime"]='%'.$param["updatetime"].'%';
        }
        $sql_where =count($sql_where) > 0 ? " where ".join(" and ",$sql_where) :"";
        $a=self::$ArticleListSelect['SQL'].$sql_where;
        return DB::select(self::$ArticleListSelect['SQL'].$sql_where,$data);


    }
}