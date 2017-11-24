<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([], function () {
    //用户管理
    Route::post('/role/user/store/{id}', ['as' => 'api.role.user.store', 'uses' => 'Api\Role\UserController@store']);
    Route::post('/role/user/update/{id}', ['as' => 'api.role.user.update', 'uses' => 'Api\Role\UserController@update']);
    Route::post('/role/user/delete/{id}', ['as' => 'api.role.user.delete', 'uses' => 'Api\Role\UserController@delete']);
    Route::post('/role/user/set-password/{id}', ['as' => 'api.role.user.set-password', 'uses' => 'Api\Role\UserController@setPassword']);
    //角色管理
    Route::post('/role/role/update/{id}', ['as' => 'api.role.role.update', 'uses' => 'Api\Role\RoleController@update']);
    Route::post('/role/role/store/{id}', ['as' => 'api.role.role.store', 'uses' => 'Api\Role\RoleController@store']);
    Route::post('/role/role/delete/{id}', ['as' => 'api.role.role.delete', 'uses' => 'Api\Role\RoleController@delete']);
    //客户账号管理
    Route::post('/fq-user/fq-user/update/{id}', ['as' => 'api.fq-user.role.update', 'uses' => 'Api\FqUser\FqUserController@update']);
    Route::post('/fq-user/fq-user/store/{id}', ['as' => 'api.fq-user.fq-user.get-user-name', 'uses' => 'Api\FqUser\FqUserController@store']);
    Route::post('/fq-user/fq-user/get-user-name', ['as' => 'api.fq-user.fq-user.store', 'uses' => 'Api\FqUser\FqUserController@getFqUserName']);
    Route::post('/fq-user/fq-user/set-password/{id}', ['as' => 'api.fq-user.fq-user.set-password', 'uses' => 'Api\FqUser\FqUserController@setPassword']);
    Route::post('/fq-user/fq-user/relevance-provider/{id}', ['as' => 'api.fq-user.fq-user.relevance-provider', 'uses' => 'Api\FqUser\FqUserController@relevanceProvider']);
    //客户反馈
    Route::post('/fq-user/fq-user-feedback/delete/{id}', ['as' => 'api.fq-user.fq-user-feedback.delete', 'uses' => 'Api\FqUser\FqUserFeedbackController@delete']);
    Route::post('/fq-user/fq-user-feedback/reject/{id}', ['as' => 'api.fq-user.fq-user-feedback.reject', 'uses' => 'Api\FqUser\FqUserFeedbackController@reject']);
    Route::post('/fq-user/fq-user-feedback/audit/{id}', ['as' => 'api.fq-user.fq-user-feedback.audit', 'uses' => 'Api\FqUser\FqUserFeedbackController@audit']);
    //供应商管理
    Route::post('/provider/provider/delete/{id}', ['as' => 'api.provider.provider.delete', 'uses' => 'Api\Provider\ProviderController@delete']);
    Route::post('/provider/provider/store/{id}', ['as' => 'api.provider.provider.store', 'uses' => 'Api\Provider\ProviderController@store']);
    Route::post('/provider/provider/brand-update/{id}', ['as' => 'api.provider.provider.brand-update', 'uses' => 'Api\Provider\ProviderController@brandUpdate']);
    Route::post('/provider/provider/brand-store/{id}', ['as' => 'api.provider.provider.brand-store', 'uses' => 'Api\Provider\ProviderController@brandStore']);
    Route::post('/provider/provider/update/{id}', ['as' => 'api.provider.provider.update', 'uses' => 'Api\Provider\ProviderController@update']);

    //供应商企业证书管理
    Route::post('/provider/provider-certificate/update/{id}', ['as' => 'api.provider.provider-certificate.update', 'uses' => 'Api\Provider\ProviderCertificateController@update']);
    Route::post('/provider/provider-certificate/store/{id}', ['as' => 'api.provider.provider-certificate.store', 'uses' => 'Api\Provider\ProviderCertificateController@store']);
    Route::post('/provider/provider-certificate/delete/{id}', ['as' => 'api.provider.provider-certificate.delete', 'uses' => 'Api\Provider\ProviderCertificateController@delete']);
    Route::post('/provider/provider-certificate/reject/{id}', ['as' => 'api.provider.provider-certificate.reject', 'uses' => 'Api\Provider\ProviderCertificateController@reject']);
    Route::post('/provider/provider-certificate/audit/{id}', ['as' => 'api.provider.provider-certificate.audit', 'uses' => 'Api\Provider\ProviderCertificateController@audit']);
    //供应商服务网点管理
    Route::post('/provider/provider-service-network/update/{id}', ['as' => 'api.provider.provider-service-network.update', 'uses' => 'Api\Provider\ProviderServiceNetworkController@update']);
    Route::post('/provider/provider-service-network/store/{id}', ['as' => 'api.provider.provider-service-network.store', 'uses' => 'Api\Provider\ProviderServiceNetworkController@store']);
    Route::post('/provider/provider-service-network/delete/{id}', ['as' => 'api.provider.provider-service-network.delete', 'uses' => 'Api\Provider\ProviderServiceNetworkController@delete']);
    Route::post('/provider/provider-service-network/audit/{id}', ['as' => 'api.provider.provider-service-network.audit', 'uses' => 'Api\Provider\ProviderServiceNetworkController@audit']);
    Route::post('/provider/provider-service-network/reject/{id}', ['as' => 'api.provider.provider-service-network.reject', 'uses' => 'Api\Provider\ProviderServiceNetworkController@reject']);

    //供应商企业动态管理
    Route::post('/provider/provider-news/update/{id}', ['as' => 'api.provider.provider-news.update', 'uses' => 'Api\Provider\ProviderNewsController@update']);
    Route::post('/provider/provider-news/store/{id}', ['as' => 'api.provider.provider-news.store', 'uses' => 'Api\Provider\ProviderNewsController@store']);
    Route::post('/provider/provider-news/delete/{id}', ['as' => 'api.provider.provider-news.delete', 'uses' => 'Api\Provider\ProviderNewsController@delete']);
    Route::post('/provider/provider-news/audit/{id}', ['as' => 'api.provider.provider-news.audit', 'uses' => 'Api\Provider\ProviderNewsController@audit']);
    Route::post('/provider/provider-news/reject/{id}', ['as' => 'api.provider.provider-news.reject', 'uses' => 'Api\Provider\ProviderNewsController@reject']);
    //验厂报告
    Route::post('/provider/provider-aduitdetails/update/{id}', ['as' => 'api.provider.provider-aduitdetails.update', 'uses' => 'Api\Provider\ProviderAduitdetailsController@update']);
    Route::post('/provider/provider-aduitdetails/store/{id}', ['as' => 'api.provider.provider-aduitdetails.store', 'uses' => 'Api\Provider\ProviderAduitdetailsController@store']);
    Route::post('/provider/provider-aduitdetails/delete/{id}', ['as' => 'api.provider.provider-aduitdetails.delete', 'uses' => 'Api\Provider\ProviderAduitdetailsController@delete']);
    //合作商
    Route::post('/provider/provider-friend/update/{id}', ['as' => 'api.provider.provider-friend.update', 'uses' => 'Api\Provider\ProviderFriendController@update']);
    Route::post('/provider/provider-friend/store/{id}', ['as' => 'api.provider.provider-friend.store', 'uses' => 'Api\Provider\ProviderFriendController@store']);
    Route::post('/provider/provider-friend/delete/{id}', ['as' => 'api.provider.provider-friend.delete', 'uses' => 'Api\Provider\ProviderFriendController@delete']);
    Route::post('/provider/provider-friend/audit/{id}', ['as' => 'api.provider.provider-friend.audit', 'uses' => 'Api\Provider\ProviderFriendController@audit']);
    Route::post('/provider/provider-friend/reject/{id}', ['as' => 'api.provider.provider-friend.reject', 'uses' => 'Api\Provider\ProviderFriendController@reject']);
    //宣传图片
    Route::post('/provider/provider-propaganda/update/{id}', ['as' => 'api.provider.provider-propaganda.update', 'uses' => 'Api\Provider\ProviderPropagandaController@update']);
    Route::post('/provider/provider-propaganda/store/{id}', ['as' => 'api.provider.provider-propaganda.store', 'uses' => 'Api\Provider\ProviderPropagandaController@store']);
    Route::post('/provider/provider-propaganda/delete/{id}', ['as' => 'api.provider.provider-propaganda.delete', 'uses' => 'Api\Provider\ProviderPropagandaController@delete']);
    Route::post('/provider/provider-propaganda/audit/{id}', ['as' => 'api.provider.provider-propaganda.audit', 'uses' => 'Api\Provider\ProviderPropagandaController@audit']);
    Route::post('/provider/provider-propaganda/reject/{id}', ['as' => 'api.provider.provider-propaganda.reject', 'uses' => 'Api\Provider\ProviderPropagandaController@reject']);
    //供应商历史项目管理
    Route::post('/provider/provider-project/update/{id}', ['as' => 'api.provider.provider-news.update', 'uses' => 'Api\Provider\ProviderProjectController@update']);
    Route::post('/provider/provider-project/store/{id}', ['as' => 'api.provider.provider-project.store', 'uses' => 'Api\Provider\ProviderProjectController@store']);
    Route::post('/provider/provider-project/delete/{id}', ['as' => 'api.provider.provider-project.delete', 'uses' => 'Api\Provider\ProviderProjectController@delete']);
    Route::post('/provider/provider-project/audit/{id}', ['as' => 'api.provider.provider-project.audit', 'uses' => 'Api\Provider\ProviderProjectController@audit']);
    Route::post('/provider/provider-project/reject/{id}', ['as' => 'api.provider.provider-project.reject', 'uses' => 'Api\Provider\ProviderProjectController@reject']);
    // 产品分类管理
    Route::post('/product/product-category/store/{id}', ['as' => 'api.product.product-category.store', 'uses' => 'Api\Product\ProductCategoryController@store']);
    Route::post('/product/product-category/update/{id}', ['as' => 'api.product.product-category.update', 'uses' => 'Api\Product\ProductCategoryController@update']);
    // 内容分类管理
    Route::post('/content/content-category/store/{id}', ['as' => 'api.content.content-category.store', 'uses' => 'Api\Content\ContentCategoryController@store']);
    Route::post('/content/content-category/update/{id}', ['as' => 'api.content.content-category.update', 'uses' => 'Api\Content\ContentCategoryController@update']);
    Route::get('/content/content-category/get-next-content-category/{id}', ['as' => 'api.content.content-category.get-next-content-category', 'uses' => 'Api\Content\ContentCategoryController@getNextContentCategory']);
    Route::get('/content/content-category/delete/{id}', ['as' => 'api.content.content-category.delete', 'uses' => 'Api\Content\ContentCategoryController@delete']);

    // 供应商产品方案
    Route::post('/provider/provider-product/update/{id}', ['as' => 'api.provider.provider-project.update', 'uses' => 'Api\Provider\ProviderProductController@update']);
    Route::post('/provider/provider-product/store/{id}', ['as' => 'api.provider.provider-project.store', 'uses' => 'Api\Provider\ProviderProductController@store']);
    Route::post('/provider/provider-product/delete/{id}', ['as' => 'api.provider.provider-project.delete', 'uses' => 'Api\Provider\ProviderProductController@delete']);
    Route::post('/provider/provider-product/audit/{id}', ['as' => 'api.provider.provider-project.audit', 'uses' => 'Api\Provider\ProviderProductController@audit']);
    Route::post('/provider/provider-product/reject/{id}', ['as' => 'api.provider.provider-project.reject', 'uses' => 'Api\Provider\ProviderProductController@reject']);

    //产品方案
    Route::post('/provider/provider-product-programme/update/{id}', ['as' => 'api.provider.provider-project-programme.update', 'uses' => 'Api\Provider\ProviderProductProgrammeController@update']);
    Route::post('/provider/provider-product-programme/store/{id}', ['as' => 'api.provider.provider-project-programme.store', 'uses' => 'Api\Provider\ProviderProductProgrammeController@store']);
    Route::post('/provider/provider-product-programme/delete/{id}', ['as' => 'api.provider.provider-project-programme.delete', 'uses' => 'Api\Provider\ProviderProductProgrammeController@delete']);
    Route::post('/provider/provider-product-programme/audit/{id}', ['as' => 'api.provider.provider-project-programme.audit', 'uses' => 'Api\Provider\ProviderProductProgrammeController@audit']);
    Route::post('/provider/provider-product-programme/reject/{id}', ['as' => 'api.provider.provider-project-programme.reject', 'uses' => 'Api\Provider\ProviderProductProgrammeController@reject']);


    Route::get('/provider/provider/get-provider-keyword', ['as' => 'api.provider.provider.get-provider-keyword', 'uses' => 'Api\Provider\ProviderController@getProviderByKeyword']);

    Route::get('/developer/developer/get-developer-keyword', ['as' => 'api.developer.developer.get-developer-keyword', 'uses' => 'Api\Developer\DeveloperController@getDeveloperByKeyword']);

    //广告
    Route::post('/advertisement/advertisement/store/{id}',
        ['as' => 'api.advertisement.advertisement.store', 'uses' => 'Api\Advertisement\AdvertisementController@store']);
    Route::post('/advertisement/advertisement/update/{id}',
        ['as' => 'api.advertisement.advertisement.update', 'uses' => 'Api\Advertisement\AdvertisementController@update']);
    Route::post('/advertisement/advertisement/delete/{id}',
        ['as' => 'api.advertisement.advertisement.delete', 'uses' => 'Api\Advertisement\AdvertisementController@delete']);

    //供应商排名
    Route::post('/provider/provider-rank-category/update/{id}', ['as' => 'api.provider.provider-rank-category.update', 'uses' => 'Api\Provider\ProviderRankCategoryController@update']);
    Route::post('/provider/provider-rank-category/store/{id}', ['as' => 'api.provider.provider-rank-category.store', 'uses' => 'Api\Provider\ProviderRankCategoryController@store']);
    Route::post('/provider/provider-rank-category/delete/{id}', ['as' => 'api.provider.provider-rank-category.delete', 'uses' => 'Api\Provider\ProviderRankCategoryController@delete']);

    //用户消息
    Route::post('/msg/user-msg/store/{id}', ['as' => 'api.msg.user-msg.store', 'uses' => 'Api\Msg\UserMsgController@store']);
    Route::post('/msg/user-msg/update/{id}', ['as' => 'api.msg.user-msg.update', 'uses' => 'Api\Msg\UserMsgController@update']);
    Route::post('/msg/user-msg/delete/{id}', ['as' => 'api.msg.user-msg.delete', 'uses' => 'Api\Msg\UserMsgController@delete']);
    //广播消息
    Route::post('/msg/broadcast-msg/store/{id}', ['as' => 'api.msg.broadcast-msg.store', 'uses' => 'Api\Msg\BroadcastMsgController@store']);
    Route::post('/msg/broadcast-msg/update/{id}', ['as' => 'api.msg.broadcast-msg.update', 'uses' => 'Api\Msg\BroadcastMsgController@update']);
    Route::post('/msg/broadcast-msg/delete/{id}', ['as' => 'api.msg.broadcast-msg.delete', 'uses' => 'Api\Msg\BroadcastMsgController@delete']);

    Route::post('/regional/china-area/store/{id}', ['as' => 'api.regional.china-area.store', 'uses' => 'Api\Regional\ChinaAreaController@store']);
    Route::post('/regional/china-area/update/{id}', ['as' => 'api.regional.china-area.update', 'uses' => 'Api\Regional\ChinaAreaController@update']);
    Route::post('/regional/china-area/delete/{id}', ['as' => 'api.regional.china-area.delete', 'uses' => 'Api\Regional\ChinaAreaController@delete']);

    Route::post('/regional/province/store/{id}', ['as' => 'api.regional.province.store', 'uses' => 'Api\Regional\ProvinceController@store']);
    Route::post('/regional/province/update/{id}', ['as' => 'api.regional.province.update', 'uses' => 'Api\Regional\ProvinceController@update']);
    Route::post('/regional/province/delete/{id}', ['as' => 'api.regional.province.delete', 'uses' => 'Api\Regional\ProvinceController@delete']);

    Route::post('/regional/city/store/{id}', ['as' => 'api.regional.city.store', 'uses' => 'Api\Regional\CityController@store']);
    Route::post('/regional/city/update/{id}', ['as' => 'api.regional.city.update', 'uses' => 'Api\Regional\CityController@update']);
    Route::post('/regional/city/delete/{id}', ['as' => 'api.regional.city.delete', 'uses' => 'Api\Regional\CityController@delete']);

    //内容
    Route::post('/content-publish/content/store/{id}', ['as' => 'api.content.content.store', 'uses' => 'Api\ContentPublish\ContentController@store']);
    Route::post('/content-publish/content/update/{id}', ['as' => 'api.content.content.update', 'uses' => 'Api\ContentPublish\ContentController@update']);
    Route::post('/content-publish/content/delete/{id}', ['as' => 'api.content.content.delete', 'uses' => 'Api\ContentPublish\ContentController@delete']);

    //媒体管理
    Route::post('/media-management/media-management/store/{id}', ['as' => 'api.media-management.media-management.store', 'uses' => 'Api\MediaManagement\MediaManagementController@store']);
    Route::post('/media-management/media-management/update/{id}', ['as' => 'api.media-management.media-management.update', 'uses' => 'Api\MediaManagement\MediaManagementController@update']);
    Route::post('/media-management/media-management/delete/{id}', ['as' => 'api.media-management.media-management.delete', 'uses' => 'Api\MediaManagement\MediaManagementController@delete']);

    Route::post('/brand/custom-product/store/{id}', ['as' => 'api.brand.custom-producte.store', 'uses' => 'Api\Brand\BrandCustomProductController@store']);
    Route::post('/brand/custom-product/update/{id}', ['as' => 'api.brand.custom-product.update', 'uses' => 'Api\Brand\BrandCustomProductController@update']);
    Route::post('/brand/custom-product/delete/{id}', ['as' => 'api.brand.custom-product.delete', 'uses' => 'Api\Brand\BrandCustomProductController@delete']);

    Route::get('/developer/loupan/get-developer-keyword',
        ['as' => 'api.developer.loupan.get-developer-keyword', 'uses' => 'Api\Developer\LoupanController@getDeveloperByKeyword']);


    Route::post('/brand/brand-certificate/store/{id}', ['as' => 'api.brand.brand-certificate.store', 'uses' => 'Api\Brand\BrandCertificateController@store']);
    Route::post('/brand/brand-certificate/update/{id}', ['as' => 'api.brand.brand-certificate.update', 'uses' => 'Api\Brand\BrandCertificateController@update']);
    Route::post('/brand/brand-certificate/delete/{id}', ['as' => 'api.brand.brand-certificate.delete', 'uses' => 'Api\Brand\BrandCertificateController@delete']);

    Route::post('/brand/brand-sale/store/{id}', ['as' => 'api.brand.brand-sale.store', 'uses' => 'Api\Brand\BrandSaleController@store']);
    Route::post('/brand/brand-sale/update/{id}', ['as' => 'api.brand.brand-sale.update', 'uses' => 'Api\Brand\BrandSaleController@update']);
    Route::post('/brand/brand-sale/delete/{id}', ['as' => 'api.brand.brand-sale.delete', 'uses' => 'Api\Brand\BrandSaleController@delete']);

    Route::post('/brand/brand-factory/store/{id}', ['as' => 'api.brand.brand-factory.store', 'uses' => 'Api\Brand\BrandFactoryController@store']);
    Route::post('/brand/brand-factory/update/{id}', ['as' => 'api.brand.brand-factory.update', 'uses' => 'Api\Brand\BrandFactoryController@update']);
    Route::post('/brand/brand-factory/delete/{id}', ['as' => 'api.brand.brand-factory.delete', 'uses' => 'Api\Brand\BrandFactoryController@delete']);

    //服务体系

    Route::post('/brand/brandService/store/{id}', ['as' => 'api.brand.brand-service.store', 'uses' => 'Api\Brand\BrandServiceController@store']);

    //渠道销售
    Route::post('/brand/sale-channel/store/{id}', ['as' => 'api.brand.sale-channel.store', 'uses' => 'Api\Brand\SaleChannelController@store']);
    Route::post('/brand/sale-channel/update/{id}', ['as' => 'api.brand.sale-channel.update', 'uses' => 'Api\Brand\SaleChannelController@update']);
    Route::post('/brand/sale-channel/delete/{id}', ['as' => 'api.brand.sale-channel.delete', 'uses' => 'Api\Brand\SaleChannelController@delete']);
    Route::post('/brand/sale-channel/modify', ['as' => 'api.brand.sale-channel.modify', 'uses' => 'Api\Brand\SaleChannelController@modify']);

    //合作客户
    Route::post('/brand/brand-cooperation/store/{id}', ['as' => 'api.brand.brand-cooperation.store', 'uses' => 'Api\Brand\BrandCooperationController@store']);
    Route::post('/brand/brand-cooperation/update/{id}', ['as' => 'api.brand.brand-cooperation.update', 'uses' => 'Api\Brand\BrandCooperationController@update']);
    Route::post('/brand/brand-cooperation/delete/{id}', ['as' => 'api.brand.brand-cooperation.delete', 'uses' => 'Api\Brand\BrandCooperationController@delete']);

    //补充资料
    Route::post('/brand/brand-supplementary/store/{id}', ['as' => 'api.brand.brand-supplementary.store', 'uses' => 'Api\Brand\BrandSupplementaryController@store']);
    Route::post('/brand/brand-supplementary/update/{id}', ['as' => 'api.brand.brand-supplementary.update', 'uses' => 'Api\Brand\BrandSupplementaryController@update']);
    Route::post('/brand/brand-supplementary/delete/{id}', ['as' => 'api.brand.brand-supplementary.delete', 'uses' => 'Api\Brand\BrandSupplementaryController@delete']);

    //项目清单
    Route::post('/brand/brand-sign/store/{id}', ['as' => 'api.brand.brand-sign.store', 'uses' => 'Api\Brand\BrandSignListController@store']);
    Route::post('/brand/brand-sign/update/{id}', ['as' => 'api.brand.brand-sign.update', 'uses' => 'Api\Brand\BrandSignListController@update']);
    Route::post('/brand/brand-sign/delete/{id}', ['as' => 'api.brand.brand-sign.delete', 'uses' => 'Api\Brand\BrandSignListController@delete']);

    Route::post('/brand/brand/keyword', ['as' => 'api.brand.brand.keyword', 'uses' => 'Api\Brand\BrandController@keyword']);
    Route::post('/brand/brand/friend/{id}', ['as' => 'api.brand.brand.friend', 'uses' => 'Api\Brand\BrandController@friend']);

    Route::post('/comment/comment/delete/{id}', ['as' => 'api.comment.comment.delete', 'uses' => 'Api\Comment\CommentController@delete']);
    //楼盘名称
    Route::post('/developer/loupan/store/{id}',
        ['as' => 'api.developer.loupan.store', 'uses' => 'Api\Developer\LoupanController@store']);
    Route::post('/developer/loupan/update/{id}',
        ['as' => 'api.developer.loupan.update', 'uses' => 'Api\Developer\LoupanController@update']);
    Route::post('/developer/loupan/delete/{id}',
        ['as' => 'api.developer.loupan.delete', 'uses' => 'Api\Developer\LoupanController@delete']);

    //项目分类
    Route::post('/developer/project-category/store/{id}',
        ['as' => 'api.developer.project-category.store', 'uses' => 'Api\Developer\ProjectCategoryController@store']);
    Route::post('/developer/project-category/update/{id}',
        ['as' => 'api.developer.project-category.update', 'uses' => 'Api\Developer\ProjectCategoryController@update']);
    Route::post('/developer/project-category/delete/{id}',
        ['as' => 'api.developer.project-category.delete', 'uses' => 'Api\Developer\ProjectCategoryController@delete']);


    Route::get('/developer/loupan/get-loupan-keyword',
        ['as' => 'api.developer.loupan.get-loupan-keyword', 'uses' => 'Api\Developer\LoupanController@getLoupanByKeyword']);

    //品类
    Route::post('/category/category/store/{id}', ['as' => 'api.category.category.store', 'uses' => 'Api\Category\CategoryController@store']);
    Route::post('/category/category/update/{id}', ['as' => 'api.category.category.update', 'uses' => 'Api\Category\CategoryController@update']);
    Route::post('/category/category/delete/{id}', ['as' => 'api.category.category.delete', 'uses' => 'Api\Category\CategoryController@delete']);

    Route::post('/category/category/attribute/{id}', ['as' => 'api.category.category.attribute', 'uses' => 'Api\Category\CategoryController@attribute']);
    Route::post('/category/category/second-level/{id}', ['as' => 'api.category.category.second-level', 'uses' => 'Api\Category\CategoryController@secondLevel']);


    //属性
    Route::post('/category/attribute/store/{id}', ['as' => 'api.category.attribute.store', 'uses' => 'Api\Category\AttributeController@store']);
    Route::post('/category/attribute/update/{id}', ['as' => 'api.category.attribute.update', 'uses' => 'Api\Category\AttributeController@update']);
    Route::post('/category/attribute/delete/{id}', ['as' => 'api.category.attribute.delete', 'uses' => 'Api\Category\AttributeController@delete']);

    //产品
    Route::post('/product/product/store/{id}', ['as' => 'api.product.product.store', 'uses' => 'Api\Product\ProductController@store']);
    Route::post('/product/product/update/{id}', ['as' => 'api.product.product.update', 'uses' => 'Api\Product\ProductController@update']);
    Route::post('/product/product/delete/{id}', ['as' => 'api.product.product.delete', 'uses' => 'Api\Product\ProductController@delete']);

    Route::post('/product/product/keyword', ['as' => 'api.product.product.keyword', 'uses' => 'Api\Product\ProductController@keyword']);

    //文章
    Route::post('/information/information/store/{id}', ['as' => 'api.information.information.store', 'uses' => 'Api\Information\InformationController@store']);
    Route::post('/information/information/update/{id}', ['as' => 'api.information.information.update', 'uses' => 'Api\Information\InformationController@update']);
    Route::post('/information/information/delete/{id}', ['as' => 'api.information.information.delete', 'uses' => 'Api\Information\InformationController@delete']);
    Route::post('/information/information/process-image/{id}', ['as' => 'api.information.information.process-image', 'uses' => 'Api\Information\InformationController@processImage']);

    //关键词
    Route::post('/tag/tag/store/{id}', ['as' => 'api.tag.tag.store', 'uses' => 'Api\Tag\TagController@store']);
    Route::post('/tag/tag/delete/{id}', ['as' => 'api.tag.tag.delete', 'uses' => 'Api\Tag\TagController@delete']);
    Route::post('/tag/tag/update/{id}', ['as' => 'api.tag.tag.update', 'uses' => 'Api\Tag\TagController@update']);

    //标签
    Route::post('/theme/theme/store/{id}', ['as' => 'api.theme.theme.store', 'uses' => 'Api\Theme\ThemeController@store']);
    Route::post('/theme/theme/delete/{id}', ['as' => 'api.theme.theme.delete', 'uses' => 'Api\Theme\ThemeController@delete']);
    Route::post('/theme/theme/update/{id}', ['as' => 'api.theme.theme.update', 'uses' => 'Api\Theme\ThemeController@update']);
});


//开发商项目
require __DIR__ . '/Routes/Developer/developer-api.php';