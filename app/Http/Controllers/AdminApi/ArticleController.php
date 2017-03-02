<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/03/01
 * Time: 下午 5:12
 */

namespace App\Http\Controllers\AdminApi;

use App\Common\StsCode;
use App\Http\Controllers\Controller;
use App\Models\ArticleModel;
use App\Models\ClassifyModel;
use App\Models\FK_UserArticleModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController  extends Controller
{
        /*添加文章分类*/
        public  function AddArticleClassify(Request $request){
            $AddArticleClassifyParams = $request->all();
            $AddArticleClassifyParams['classify_id']=autoIncrementMD5();
            $AddArticleClassifyData=  DB::insert( ClassifyModel::$AddArticleClassifyInsert['SQL'],$AddArticleClassifyParams);

                if($AddArticleClassifyData)
                    return  response()->json(outJson(StsCode::STATUS_SUCCESS,'类型添加成功'));
                    else
                    return  response()->json(outJson(StsCode::STATUS_ERROR,'类型添加失败'));
}

        /*添加文章*/
         public  function AddArticle(Request $request){
             DB::beginTransaction();
             try{
                 $AddArticleParams= $request->all();

                 $AddArticleParams['article_id'] = autoIncrementMD5();
                 $AddArticleParams['author'] = session('userinfo.username');
                 $AddArticleParams['updatetime'] = currentDateTime();

                 $AddArticleData=DB::insert(ArticleModel::$AddArticleInsert['SQL'],$AddArticleParams);
                 $FK_UserArticle = DB::insert(FK_UserArticleModel::$FK_UserArticleInsert['SQL'],[
                     'user_article_id'=>autoIncrementMD5(),
                     'user_id'=>session('userinfo.user_id'),
                     'article_id'=>$AddArticleParams['article_id']

                 ]);
                 if($AddArticleData && $FK_UserArticle)
                     return  response()->json(outJson(StsCode::STATUS_SUCCESS,'添加文章成功'));
                 else
                     return  response()->json(outJson(StsCode::STATUS_ERROR,'添文章加失败'));
             }catch (QueryException $ex){
                 return  response()->json(outJson(StsCode::STATUS_ERROR,'添文章加失败'));
             }



         }

        /*文章列表*/
        public  function  ArticleList(){
            $ArticleListData= DB::select(ArticleModel::$ArticleListSelect['SQL']);
            if($ArticleListData)
                return  response()->json(outJson(StsCode::STATUS_SUCCESS,'查询成功',$ArticleListData));
            else
                return  response()->json(outJson(StsCode::STATUS_ERROR,'查询失败'));
        }
}