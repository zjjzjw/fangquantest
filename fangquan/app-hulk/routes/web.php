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

Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);

Route::group(['middleware' => ['api.response']], function () {
    Route::get('/api/information/detail/{id}',
        ['as' => 'api.information.detail', 'uses' => 'Information\InformationController@detail']);

    Route::get('api/information/index',
        ['as' => 'api.information.index', 'uses' => 'Information\InformationController@index']);

    Route::get('api/information/theme',
        ['as' => 'api.information.theme', 'uses' => 'Information\InformationController@theme']);

    Route::get('api/category/top-category',
        ['as' => 'api.information.top-category', 'uses' => 'Category\CategoryController@getTopCategory']);

    Route::get('api/category/second-category/{id}',
        ['as' => 'api.information.second-category', 'uses' => 'Category\CategoryController@getSecondCategory']);

    Route::get('api/category/category-attribute/{id}',
        ['as' => 'api.information.category-attribute', 'uses' => 'Category\CategoryController@getCategoryAttribute']);

    Route::get('api/product/index',
        ['as' => 'api.product.index', 'uses' => 'Product\ProductController@index']);

    Route::get('api/product/theme',
        ['as' => 'api.product.theme', 'uses' => 'Product\ProductController@theme']);

    Route::get('api/product/detail/{id}',
        ['as' => 'api.product.detail', 'uses' => 'Product\ProductController@detail']);

    Route::get('api/product/comment/{id}',
        ['as' => 'api.product.comment', 'uses' => 'Product\ProductController@comment']);

    Route::get('api/brand/index',
        ['as' => 'api.brand.index', 'uses' => 'Brand\BrandController@index']);
    Route::get('api/brand/detail/{id}',
        ['as' => 'api.brand.detail', 'uses' => 'Brand\BrandController@detail']);
    Route::get('api/brand/product/{id}',
        ['as' => 'api.brand.product', 'uses' => 'Brand\BrandController@product']);
    Route::get('api/brand/comment/{id}',
        ['as' => 'api.brand.comment', 'uses' => 'Brand\BrandController@comment']);

    Route::post('api/user/login',
        ['as' => 'api.user.login', 'uses' => 'User\UserController@login']);

    Route::post('api/comment/store',
        ['as' => 'api.comment.store', 'uses' => 'Comment\CommentController@store']);
});


//首页展会部分
Route::group(['middleware' => ['api.response']], function () {
    //展会服务
    Route::get('api/exhibition/service',
        ['as' => 'api.exhibition.service', 'uses' => 'Exhibition\ExhibitionController@service']);
    //展会概况
    Route::get('api/exhibition/survey',
        ['as' => 'api.exhibition.survey', 'uses' => 'Exhibition\ExhibitionController@survey']);
    //展会回顾
    Route::get('api/exhibition/review',
        ['as' => 'api.exhibition.review', 'uses' => 'Exhibition\ExhibitionController@review']);
    //展会成果
    Route::get('api/exhibition/result',
        ['as' => 'api.exhibition.result', 'uses' => 'Exhibition\ExhibitionController@result']);
    //内容详情
    Route::get('api/exhibition/detail/{id}',
        ['as' => 'api.exhibition.detail', 'uses' => 'Exhibition\ExhibitionController@detail']);
    //精彩片刻更多
    Route::get('api/exhibition/flashback/allaudio/{page}',
        ['as' => 'api.exhibition.flashback.allaudio', 'uses' => 'Exhibition\ExhibitionController@allAudios']);
    //展会成果更多
    Route::get('api/exhibition/result-more/{page}',
        ['as' => 'api.exhibition.result-more', 'uses' => 'Exhibition\ExhibitionController@allResult']);
    //展会回顾更多
    Route::get('api/exhibition/review-more/{page}',
        ['as' => 'api.exhibition.review-more', 'uses' => 'Exhibition\ExhibitionController@allReview']);
    //展会首页
    Route::get('api/exhibition/exhibition-home',
        ['as' => 'api.exhibition.exhibition-home', 'uses' => 'Exhibition\ExhibitionController@exhibition']);


    //项目招标类型 项目一级分类
    Route::get('api/developer/project-category/index',
        ['as' => 'api.developer.project-category', 'uses' => 'Developer\ProjectCategoryController@index']);
    //项目二级分类
    Route::get('api/developer/project-category/second-category',
        ['as' => 'api.developer.project-category', 'uses' => 'Developer\ProjectCategoryController@secondCategory']);
    //项目列表
    Route::get('api/developer/developer-project/list',
        ['as' => 'api.developer.developer-project.list', 'uses' => 'Developer\DeveloperProjectController@index']);
    //项目详情
    Route::get('api/developer/developer-project/detail/{id}',
        ['as' => 'api.developer.developer-project.detail', 'uses' => 'Developer\DeveloperProjectController@detail']);
    //区域列表
    Route::get('api/area/list',
        ['as' => 'api.area.list', 'uses' => 'Area\AreaController@index']);
    //个人信息
    Route::get('api/user/user-info',
        ['as' => 'api.user.user-info', 'uses' => 'User\UserController@userInfo']);

});


