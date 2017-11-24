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


//登录相关
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@login']);

Route::get('/register', ['as' => 'register', 'uses' => 'Auth\RegisterController@register']);
Route::get('/reset-password', ['as' => 'reset-password', 'uses' => 'Auth\ResetPasswordController@resetPassword']);

// 供应商列表
Route::get('/provider/list', ['as' => 'provider.list', 'uses' => 'Provider\ProviderListController@index']);
// 供应商企业基本信息
Route::get('/provider/enterprise-info/{provider_id}', ['as' => 'provider.enterprise-info.index', 'uses' => 'Provider\ProviderEnterpriseInfoController@index']);
// 供应商产品方案--产品列表
Route::get('/provider/product-scheme/{provider_id}/product',
    ['as' => 'provider.product-scheme.product', 'uses' => 'Provider\ProviderProductSchemeController@productList']);
// 供应商产品方案--方案列表
Route::get('/provider/product-scheme/{provider_id}/scheme',
    ['as' => 'provider.product-scheme.scheme', 'uses' => 'Provider\ProviderProductSchemeController@schemeList']);
// 供应商产品方案--产品详细信息
Route::get('/provider/product-scheme/{provider_id}/product/{provider_product_id}',
    ['as' => 'provider.product-scheme.product.detail', 'uses' => 'Provider\ProviderProductSchemeController@productDetail']);

// 供应商产品方案--方案详细信息
Route::get('/provider/product-scheme/{provider_id}/scheme/{provider_scheme_id}',
    ['as' => 'provider.product-detail.scheme.detail', 'uses' => 'Provider\ProviderProductSchemeController@schemeDetail']);

// 开发商列表
Route::get('/developer/list', ['as' => 'developer.list', 'uses' => 'Developer\DeveloperController@index']);
Route::get('/developer/developer-project/list', ['as' => 'developer.developer-project.list', 'uses' => 'Developer\DeveloperProjectController@index']);
Route::get('/developer/developer-project/detail/{developer_project_id}', ['as' => 'developer.developer-project.detail', 'uses' => 'Developer\DeveloperProjectController@detail']);

// 调查问卷尾页
Route::get('/exhibition/gather/shadowe', ['as' => 'exhibition.gather.shadowe', 'uses' => 'Exhibition\GatherController@shadowe']);


//调查问卷首页
Route::get('/exhibition/exhibition', ['as' => 'exhibition.exhibition', 'uses' => 'Exhibition\HomeController@exhibition']);

//展会h5首页
Route::get('/',
    ['as' => 'exhibition.exhibition-h5.exhibition-h5', 'uses' => 'Exhibition\ExhibitionH5Controller@index']);


//展会概况start
Route::get('/exhibition/flashback/index', ['as' => 'exhibition.flashback.index', 'uses' => 'Exhibition\ExhibitionH5Controller@flashbackIndex']);
Route::get('/exhibition/flashback/audio/{id}', ['as' => 'exhibition.flashback.audio', 'uses' => 'Exhibition\ExhibitionH5Controller@flashbackAudio']);

Route::get('/exhibition/cooperation', ['as' => 'exhibition.cooperation', 'uses' => 'Exhibition\ExhibitionH5Controller@cooperation']);

//展会概况
Route::get('/exhibition/introduce', ['as' => 'exhibition.introduce', 'uses' => 'Exhibition\ExhibitionH5Controller@introduce']);
Route::get('/exhibition/activity', ['as' => 'exhibition.activity', 'uses' => 'Exhibition\ExhibitionH5Controller@activity']);
//展会服务
Route::get('/exhibition/service', ['as' => 'exhibition.service', 'uses' => 'Exhibition\ExhibitionH5Controller@service']);
//展会成果
Route::get('/exhibition/result', ['as' => 'exhibition.result', 'uses' => 'Exhibition\ExhibitionH5Controller@result']);
Route::get('/exhibition/result-detail/{id}', ['as' => 'exhibition.result-detail', 'uses' => 'Exhibition\ExhibitionH5Controller@resultDetail']);

//展商列表end
Route::get('/exhibition/provider-list', ['as' => 'exhibition.provider-list', 'uses' => 'Exhibition\ExhibitionH5Controller@providerList']);
Route::get('/exhibition/developer-list', ['as' => 'exhibition.developer-list', 'uses' => 'Exhibition\ExhibitionH5Controller@developerList']);

//展会回顾
Route::get('/review/list', ['as' => 'review.list', 'uses' => 'Review\ReviewController@index']);
Route::get('/review/detail/{id}', ['as' => 'review.detail', 'uses' => 'Review\ReviewController@detail']);

//关于房圈
Route::get('/station/about', ['as' => 'station.about', 'uses' => 'Station\StationController@about']);
Route::get('/station/contact', ['as' => 'station.contact', 'uses' => 'Station\StationController@contact']);
Route::get('/station/agreement', ['as' => 'station.agreement', 'uses' => 'Station\StationController@agreement']);
Route::get('/station/recruitmen', ['as' => 'station.recruitmen', 'uses' => 'Station\StationController@recruitmen']);

// 展会注册
Route::get('/exhibition/gather/register', ['as' => 'exhibition.gather.register', 'uses' => 'Exhibition\GatherController@register']);
//会议流程
Route::get('/exhibition/gather/agenda', ['as' => 'exhibition.gather.agenda', 'uses' => 'Exhibition\GatherController@agenda']);

//供应商问题
Route::get('/exhibition/question/provider-qs', ['as' => 'exhibition.question.provider-qs', 'uses' => 'Exhibition\QuestionController@providerQs']);

Route::get('/exhibition/question/developer-qs', ['as' => 'exhibition.question.developer-qs', 'uses' => 'Exhibition\QuestionController@developerQs']);

// 展会H5开发商列表
Route::get('/exhibition/developer/index', ['as' => 'exhibition.developer.index', 'uses' => 'Exhibition\DeveloperController@index']);

Route::get('/exhibition/developer-project/list', ['as' => 'exhibition.developer-project.list', 'uses' => 'Exhibition\DeveloperProjectController@list']);
Route::get('/exhibition/developer-project/detail/{id}', ['as' => 'exhibition.developer-project.detail', 'uses' => 'Exhibition\DeveloperProjectController@detail']);
//展会供应商列表


// 展会H5开发商列表
Route::get('/exhibition/provider/index', ['as' => 'exhibition.provider.index', 'uses' => 'Exhibition\ProviderController@index']);
Route::get('/exhibition/provider/detail/{id}', ['as' => 'exhibition.provider.detail', 'uses' => 'Exhibition\ProviderController@detail']);

//回调地址
Route::get('/exhibition/callback', ['as' => 'exhibition.token', 'uses' => 'Exhibition\GatherController@token']);
Route::post('/exhibition/callback', ['as' => 'exhibition.callback', 'uses' => 'Exhibition\GatherController@callback']);