<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('test');
});


Route::group(['prefix'=>'AdminApi','namespace'=>'AdminApi'],function (){


    Route::post("/SignIn",'UserController@SignIn');
    Route::post("/Register",'UserController@Register');
    Route::post("/CheckUsername",'UserController@CheckUsername');



    Route::group(['middleware'=>'checkLogin'],function (){
        //登出
        Route::post("/SignOut",'UserController@SignOut');
        //获取用户信息
        Route::post("/GetUserInfo",'UserController@GetUserInfo');
        //修改用户信息
        Route::post("/EditUserInfo",'UserController@EditUserInfo');
        Route::post("/EditUserAvatar",'UserController@EditUserAvatar');



        //添加文章分类
        Route::post("/AddArticleClassify",'ArticleController@AddArticleClassify');
        //查询文章分类
        Route::post("/selectArticleClassify",'ArticleController@selectArticleClassify');
        //添加文章
        Route::post("/AddArticle",'ArticleController@AddArticle');
        //查询文章列表
        Route::post("/ArticleList",'ArticleController@ArticleList');

    });

});
