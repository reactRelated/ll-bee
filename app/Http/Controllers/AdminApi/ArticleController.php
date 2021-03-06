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
use Illuminate\Support\Facades\Validator;

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
        /*查找分类列表*/
        public  function  selectArticleClassify (){
            $selectArticleClassifyData=  DB::select( ClassifyModel::$SelectArticleClassifySelect['SQL']);
            if($selectArticleClassifyData)
                return  response()->json(outJson(StsCode::STATUS_SUCCESS,'查询成功',$selectArticleClassifyData));
            else
                return  response()->json(outJson(StsCode::STATUS_ERROR,'查询失败'));
        }

        /*添加文章*/
         public  function AddArticle(Request $request){
           $AddArticleTransaction= DB::transaction(function()use($request){

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
               }catch (QueryException $ex){
                   DB::rollback();
                   return  response()->json(outJson(StsCode::STATUS_ERROR,$ex));
               }

             });

             return $AddArticleTransaction;
            /* try{
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

                 if($AddArticleData && $FK_UserArticle){
                     DB::commit();
                     return  response()->json(outJson(StsCode::STATUS_SUCCESS,'添加文章成功'));
                 }
                 else{
                     DB::rollback();
                     return  response()->json(outJson(StsCode::STATUS_ERROR,'添文章加失败'));
                 }


             }catch (QueryException $ex){
                 DB::rollback();
                 return  response()->json(outJson(StsCode::STATUS_ERROR,'添文章加失败'));
             }*/



         }

        /*文章列表*/
        public  function  ArticleList(Request $request){

            /*$ArticleListParam = Validator::make(
                $request->all(),
                [
                    'title' => 'present',
                    'classify' => 'present',
                    'author' => 'present',
                    'updatetime' => 'present'
                ]);

            if ($ArticleListParam->fails()) {

                return  response()->json(outJson(StsCode::STATUS_SUCCESS,$ArticleListParam->errors()->first()));
            }

            $ArticleListData=$ArticleListParam->getData();*/
            $ArticleListData=$request->all();
            try{
            $ArticleListRes=ArticleModel::doQueryArticleList($ArticleListData);

            if(count($ArticleListRes)>0)
                return  response()->json(outJson(StsCode::STATUS_SUCCESS,'查询成功',$ArticleListRes));
            else
                return  response()->json(outJson(StsCode::STATUS_SUCCESS,'未能查到数据',$ArticleListRes));
            }catch(QueryException $ex){
                return  response()->json(outJson(StsCode::STATUS_ERROR,'查询失败',$ex));
            }

        }
}