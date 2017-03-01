<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/03/01
 * Time: 下午 5:12
 */

namespace App\Http\Controllers\AdminApi;


use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use Illuminate\Http\Request;

class ArticleController  extends Controller
{
        /*添加文章*/
         public  function AddArticle(Request $request){
            $AddArticleData = $request->all();

             $AddArticleData['article_id'] = autoIncrementMD5();
             $AddArticleData['author'] = session('username');
             $AddArticleData['updatetime'] = currentDateTime();

             $UserData=DB::insert(ArticleModel::$AddArticleInsert['SQL'],$AddArticleData);
         }

        /*文章列表*/
}