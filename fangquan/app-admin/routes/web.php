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
Route::get('/login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('/login', ['as' => 'post.login', 'uses' => 'Auth\LoginController@login']);
Route::get('/logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('/error', ['as' => 'error', 'uses' => 'ErrorController@index']);

Route::get('/api/qi-niu/storage-tokens', ['uses' => 'Api\QiniuController@actionStorageTokens']);
Route::post('/api/qi-niu/create', ['uses' => 'Api\QiniuCallbackController@create']);


Route::group(['middleware' => 'guest'], function () {
    Route::get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);
    Route::get('/home', ['as' => 'home.index', 'uses' => 'HomeController@index']);
    //产品分类
    Route::get('/product/product-category/index', ['as' => 'product.product-category.index', 'uses' => 'Product\ProductCategoryController@index']);
    Route::get('/product/product-category/edit/{id}', ['as' => 'product.product-category.edit', 'uses' => 'Product\ProductCategoryController@edit']);

    //用户管理
    Route::get('/role/user/index', ['as' => 'role.user.index', 'uses' => 'Role\UserController@index'])
        ->middleware('role');
    Route::get('/role/user/edit/{id}', ['as' => 'role.user.edit', 'uses' => 'Role\UserController@edit'])
        ->middleware('role');

    Route::get('/role/user/set-password/{id}', ['as' => 'role.user.set-password', 'uses' => 'Role\UserController@setPassword']);
    //角色管理
    Route::get('/role/role/index', ['as' => 'role.role.index', 'uses' => 'Role\RoleController@index']);
    Route::get('/role/role/edit/{id}', ['as' => 'role.role.edit', 'uses' => 'Role\RoleController@edit']);

    //客户账号管理
    Route::get('/fq-user/fq-user/index', ['as' => 'fq-user.fq-user.index', 'uses' => 'FqUser\FqUserController@index']);
    Route::get('/fq-user/fq-user/edit/{id}', ['as' => 'fq-user.fq-user.edit', 'uses' => 'FqUser\FqUserController@edit']);
    Route::get('/fq-user/fq-user/set-password/{id}', ['as' => 'fq-user.fq-user.set-password', 'uses' => 'FqUser\FqUserController@setPassword']);
    Route::get('/fq-user/fq-user/bind/{id}', ['as' => 'fq-user.fq-user.bind', 'uses' => 'FqUser\FqUserController@bind']);
    //客户反馈
    Route::get('/fq-user/fq-user-feedback/index', ['as' => 'fq-user.fq-user-feedback.index', 'uses' => 'FqUser\FqUserFeedbackController@index']);
    Route::get('/fq-user/fq-user-feedback/edit/{id}', ['as' => 'fq-user.fq-user-feedback.edit', 'uses' => 'FqUser\FqUserFeedbackController@edit']);

    //供应商列表
    Route::get('/provider/provider/index', ['as' => 'provider.provider.index', 'uses' => 'Provider\ProviderController@index']);
    //供应商基本信息页
    Route::get('/provider/provider/edit/{id}', ['as' => 'provider.provider.edit', 'uses' => 'Provider\ProviderController@edit']);

    //品牌基本信息
    Route::get('/brand/edit/{id}', ['as' => 'brand.edit', 'uses' => 'Brand\BrandController@edit']);
    //品牌服务
    Route::get('/brand/brand-service/edit/{id}', ['as' => 'brand.brand-service.edit', 'uses' => 'Brand\BrandServiceController@edit']);
    //战略合作客户
    Route::get('/brand/{brand_id}/cooperation/index', ['as' => 'brand.cooperation.index', 'uses' => 'Brand\BrandCooperationController@index']);
    Route::get('/brand/{brand_id}/cooperation/edit/{id}', ['as' => 'brand.cooperation.edit', 'uses' => 'Brand\BrandCooperationController@edit']);
    //项目清单
    Route::get('/brand/{brand_id}/brand-sign/index', ['as' => 'brand.brand-sign.index', 'uses' => 'Brand\BrandSignListController@index']);
    Route::get('/brand/{brand_id}/brand-sign/edit/{id}', ['as' => 'brand.brand-sign.edit', 'uses' => 'Brand\BrandSignListController@edit']);
    //认证证书
    Route::get('/brand/{brand_id}/brand-certificate/index', ['as' => 'brand.brand-certificate.index', 'uses' => 'Brand\BrandCertificateController@index']);
    Route::get('/brand/{brand_id}/brand-certificate/edit/{id}', ['as' => 'brand.brand-certificate.edit', 'uses' => 'Brand\BrandCertificateController@edit']);
    //厂家管理
    Route::get('/brand/{brand_id}/brand-factory/index', ['as' => 'brand.brand-factory.index', 'uses' => 'Brand\BrandFactoryController@index']);
    Route::get('/brand/{brand_id}/brand-factory/edit/{id}', ['as' => 'brand.brand-factory.edit', 'uses' => 'Brand\BrandFactoryController@edit']);
    //销售负责人
    Route::get('/brand/{brand_id}/brand-sales/index', ['as' => 'brand.brand-sales.index', 'uses' => 'Brand\BrandSalesController@index']);
    Route::get('/brand/{brand_id}/brand-sales/edit/{id}', ['as' => 'brand.brand-sales.edit', 'uses' => 'Brand\BrandSalesController@edit']);
    //定制产品
    Route::get('/brand/{brand_id}/custom-product/index', ['as' => 'brand.custom-product.index', 'uses' => 'Brand\BrandCustomProductController@index']);
    Route::get('/brand/{brand_id}/custom-product/edit/{id}', ['as' => 'brand.custom-product.edit', 'uses' => 'Brand\BrandCustomProductController@edit']);
    //销售额
    Route::get('/brand/sale-channel/modify/{id}', ['as' => 'brand.sale-channel.modify', 'uses' => 'Brand\SaleChannelController@modify']);
    //补充资料
    Route::get('/brand/{brand_id}/supplementary/index', ['as' => 'brand.supplementary.index', 'uses' => 'Brand\SupplementaryController@index']);
    Route::get('/brand/{brand_id}/supplementary/edit/{id}', ['as' => 'brand.supplementary.edit', 'uses' => 'Brand\SupplementaryController@edit']);
    //评论
    Route::get('/brand/comments/{pid}', ['as' => 'brand.comments', 'uses' => 'Brand\BrandController@comments']);

    //产品方案
    Route::get('/provider/{provider_id}/provider-product/index',
        ['as' => 'provider.provider-product.index', 'uses' => 'Provider\ProviderProductController@index']);
    Route::get('/provider/{provider_id}/provider-product/edit/{id}',
        ['as' => 'provider.provider-product.edit', 'uses' => 'Provider\ProviderProductController@edit']);
    Route::get('/provider/provider-product/list',
        ['as' => 'provider.provider-product.list', 'uses' => 'Provider\ProviderProductController@list']);
    Route::get('/provider/provider-product/audit/{id}',
        ['as' => 'provider.provider-product.audit', 'uses' => 'Provider\ProviderProductController@audit']);

    Route::get('/provider/{provider_id}/provider-product-programme/index',
        ['as' => 'provider.provider-product-programme.index', 'uses' => 'Provider\ProviderProductProgrammeController@index']);
    Route::get('/provider/{provider_id}/provider-product-programme/edit/{id}',
        ['as' => 'provider.provider-product-programme.edit', 'uses' => 'Provider\ProviderProductProgrammeController@edit']);
    Route::get('/provider/provider-product-programme/list',
        ['as' => 'provider.provider-product-programme.list', 'uses' => 'Provider\ProviderProductProgrammeController@list']);
    Route::get('/provider/provider-product-programme/audit/{id}',
        ['as' => 'provider.provider-product-programme.audit', 'uses' => 'Provider\ProviderProductProgrammeController@audit']);

    //验厂报告
    Route::get('/provider/{provider_id}/provider-aduitdetails/index',
        ['as' => 'provider.provider-aduitdetails.index', 'uses' => 'Provider\ProviderAduitdetailsController@index']);
    Route::get('/provider/{provider_id}/provider-aduitdetails/edit/{id}',
        ['as' => 'provider.provider-aduitdetails.edit', 'uses' => 'Provider\ProviderAduitdetailsController@edit']);

    //战略合作开发商
    Route::get('/provider/{provider_id}/provider-friend/index',
        ['as' => 'provider.provider-friend.index', 'uses' => 'Provider\ProviderFriendController@index']);
    Route::get('/provider/{provider_id}/provider-friend/edit/{id}',
        ['as' => 'provider.provider-friend.edit', 'uses' => 'Provider\ProviderFriendController@edit']);
    Route::get('/provider/provider-friend/list',
        ['as' => 'provider.provider-friend.list', 'uses' => 'Provider\ProviderFriendController@list']);
    Route::get('/provider/provider-friend/audit/{id}',
        ['as' => 'provider.provider-friend.audit', 'uses' => 'Provider\ProviderFriendController@audit']);


    //宣传图片,视频
    Route::get('/provider/{provider_id}/provider-propaganda/index',
        ['as' => 'provider.provider-propaganda.index', 'uses' => 'Provider\ProviderPropagandaController@index']);
    Route::get('/provider/{provider_id}/provider-propaganda/edit/{id}',
        ['as' => 'provider.provider-propaganda.edit', 'uses' => 'Provider\ProviderPropagandaController@edit']);
    Route::get('/provider/provider-propaganda/list',
        ['as' => 'provider.provider-propaganda.list', 'uses' => 'Provider\ProviderPropagandaController@list']);
    Route::get('/provider/provider-propaganda/audit/{id}',
        ['as' => 'provider.provider-propaganda.audit', 'uses' => 'Provider\ProviderPropagandaController@audit']);

    //企业证书
    Route::get('/provider/{provider_id}/provider-certificate/index',
        ['as' => 'provider.provider-certificate.index', 'uses' => 'Provider\ProviderCertificateController@index']);
    Route::get('/provider/{provider_id}/provider-certificate/edit/{id}',
        ['as' => 'provider.provider-certificate.edit', 'uses' => 'Provider\ProviderCertificateController@edit']);
    Route::get('/provider/provider-certificate/list',
        ['as' => 'provider.provider-certificate.list', 'uses' => 'Provider\ProviderCertificateController@list']);
    Route::get('/provider/provider-certificate/audit/{id}',
        ['as' => 'provider.provider-certificate.audit', 'uses' => 'Provider\ProviderCertificateController@audit']);

    //服务网点
    Route::get('/provider/{provider_id}/provider-service-network/index',
        ['as' => 'provider.provider-service-network.index', 'uses' => 'Provider\ProviderServiceNetworkController@index']);
    Route::get('/provider/{provider_id}/provider-service-network/edit/{id}',
        ['as' => 'provider.provider-service-network.edit', 'uses' => 'Provider\ProviderServiceNetworkController@edit']);
    Route::get('/provider/provider-service-network/list',
        ['as' => 'provider.provider-service-network.list', 'uses' => 'Provider\ProviderServiceNetworkController@list']);
    Route::get('/provider/provider-service-network/audit/{id}',
        ['as' => 'provider.provider-service-network.audit', 'uses' => 'Provider\ProviderServiceNetworkController@audit']);


    //历史项目
    Route::get('/provider/{provider_id}/provider-project/index',
        ['as' => 'provider.provider-project.index', 'uses' => 'Provider\ProviderProjectController@index']);
    Route::get('/provider/{provider_id}/provider-project/edit/{id}',
        ['as' => 'provider.provider-project.edit', 'uses' => 'Provider\ProviderProjectController@edit']);
    Route::get('/provider/provider-project/list',
        ['as' => 'provider.provider-project.list', 'uses' => 'Provider\ProviderProjectController@list']);
    Route::get('/provider/provider-project/audit/{id}',
        ['as' => 'provider.provider-project.audit', 'uses' => 'Provider\ProviderProjectController@audit']);


    //企业动态
    Route::get('/provider/{provider_id}/provider-news/index',
        ['as' => 'provider.provider-news.index', 'uses' => 'Provider\ProviderNewsController@index']);
    Route::get('/provider/{provider_id}/provider-news/edit/{id}',
        ['as' => 'provider.provider-news.edit', 'uses' => 'Provider\ProviderNewsController@edit']);
    Route::get('/provider/provider-news/list',
        ['as' => 'provider.provider-news.list', 'uses' => 'Provider\ProviderNewsController@list']);
    Route::get('/provider/provider-news/audit/{id}',
        ['as' => 'provider.provider-news.audit', 'uses' => 'Provider\ProviderNewsController@audit']);


    //广告
    Route::get('/advertisement/advertisement/index',
        ['as' => 'advertisement.advertisement.index', 'uses' => 'Advertisement\AdvertisementController@index']);
    Route::get('/advertisement/advertisement/edit/{id}',
        ['as' => 'advertisement.advertisement.edit', 'uses' => 'Advertisement\AdvertisementController@edit']);

    Route::get('/provider/provider-rank-category/index',
        ['as' => 'provider.provider-rank-category.index', 'uses' => 'Provider\ProviderRankCategoryController@index']);
    Route::get('/provider/provider-rank-category/edit/{id}',
        ['as' => 'provider.provider-rank-category.edit', 'uses' => 'Provider\ProviderRankCategoryController@edit']);

    //消息
    Route::get('/msg/user-msg/index',
        ['as' => 'msg.user-msg.index', 'uses' => 'Msg\UserMsgController@index']);
    Route::get('/msg/user-msg/send/{id}',
        ['as' => 'msg.user-msg.send', 'uses' => 'Msg\UserMsgController@send']);

    Route::get('/msg/broadcast-msg/index',
        ['as' => 'msg.broadcast-msg.index', 'uses' => 'Msg\BroadcastMsgController@index']);
    Route::get('/msg/broadcast-msg/send/{id}',
        ['as' => 'msg.broadcast-msg.send', 'uses' => 'Msg\BroadcastMsgController@send']);

    //区域
    Route::get('/regional/china-area/index',
        ['as' => 'regional.china-area.index', 'uses' => 'Regional\ChinaAreaController@index']);
    Route::get('/regional/china-area/edit/{id}',
        ['as' => 'regional.china-area.edit', 'uses' => 'Regional\ChinaAreaController@edit']);

    //省份
    Route::get('/regional/province/index',
        ['as' => 'regional.province.index', 'uses' => 'Regional\ProvinceController@index']);
    Route::get('/regional/province/edit/{id}',
        ['as' => 'regional.province.edit', 'uses' => 'Regional\ProvinceController@edit']);

    //城市
    Route::get('/regional/city/index',
        ['as' => 'regional.city.index', 'uses' => 'Regional\CityController@index']);
    Route::get('/regional/city/edit/{id}',
        ['as' => 'regional.city.edit', 'uses' => 'Regional\CityController@edit']);

    //内容发布
    Route::get('/content-publish/category/index',
        ['as' => 'content-publish.category.index', 'uses' => 'ContentPublish\ContentCategoryController@index']);
    Route::get('/content-publish/{parent_id}/category/edit/{id}',
        ['as' => 'content-publish.category.edit', 'uses' => 'ContentPublish\ContentCategoryController@edit']);

    //内容管理
    Route::get('/content-publish/content/index',
        ['as' => 'content-publish.content.index', 'uses' => 'ContentPublish\ContentController@index']);
    Route::get('/content-publish/content/edit/{id}',
        ['as' => 'content-publish.content.edit', 'uses' => 'ContentPublish\ContentController@edit']);

    //展会广告图标展示
    Route::get('/media-management/index',
        ['as' => 'media-management.index', 'uses' => 'MediaManagement\MediaManagementController@index']);
    Route::get('/media-management/edit/{id}',
        ['as' => 'media-management.edit', 'uses' => 'MediaManagement\MediaManagementController@edit']);


    //认证证书
    Route::get('/brand/{brand_id}/brand-certificate/index', ['as' => 'brand.brand-certificate.index', 'uses' => 'Brand\BrandCertificateController@index']);
    Route::get('/brand/{brand_id}/brand-certificate/edit/{id}', ['as' => 'brand.brand-certificate.edit', 'uses' => 'Brand\BrandCertificateController@edit']);
    //分厂
    Route::get('/brand/{brand_id}/brand-factory/index', ['as' => 'brand.brand-factory.index', 'uses' => 'Brand\BrandFactoryController@index']);
    Route::get('/brand/{brand_id}/brand-factory/edit/{id}', ['as' => 'brand.brand-factory.edit', 'uses' => 'Brand\BrandFactoryController@edit']);
    //销售负责人
    Route::get('/brand/{brand_id}/brand-sales/index', ['as' => 'brand.brand-sales.index', 'uses' => 'Brand\BrandSalesController@index']);
    Route::get('/brand/{brand_id}/brand-sales/edit/{id}', ['as' => 'brand.brand-sales.edit', 'uses' => 'Brand\BrandSalesController@edit']);

    //各渠道销售额
    Route::get('/brand/{brand_id}/sale-channel/index', ['as' => 'brand.sale-channel.index', 'uses' => 'Brand\SaleChannelController@index']);
    Route::get('/brand/{brand_id}/sale-channel/edit/{id}', ['as' => 'brand.sale-channel.edit', 'uses' => 'Brand\SaleChannelController@edit']);
    Route::get('/brand/{brand_id}/sale-channel/report', ['as' => 'brand.sale-channel.report', 'uses' => 'Brand\SaleChannelController@report']);

    //补充资料
    Route::get('/brand/{brand_id}/supplementary/index', ['as' => 'brand.supplementary.index', 'uses' => 'Brand\SupplementaryController@index']);
    Route::get('/brand/{brand_id}/supplementary/edit/{id}', ['as' => 'brand.supplementary.edit', 'uses' => 'Brand\SupplementaryController@edit']);

    //品牌服务
    Route::get('/brand/brand-service/edit/{id}', ['as' => 'brand.brand-service.edit', 'uses' => 'Brand\BrandServiceController@edit']);

    //战略合作客户
    Route::get('/brand/{brand_id}/cooperation/index', ['as' => 'brand.cooperation.index', 'uses' => 'Brand\BrandCooperationController@index']);
    Route::get('/brand/{brand_id}/cooperation/edit/{id}', ['as' => 'brand.cooperation.edit', 'uses' => 'Brand\BrandCooperationController@edit']);

    //项目清单
    Route::get('/brand/{brand_id}/brand-sign/index', ['as' => 'brand.brand-sign.index', 'uses' => 'Brand\BrandSignListController@index']);
    Route::get('/brand/{brand_id}/brand-sign/edit/{id}', ['as' => 'brand.brand-sign.edit', 'uses' => 'Brand\BrandSignListController@edit']);

    //定制产品
    Route::get('/brand/{brand_id}/custom-product/index', ['as' => 'brand.custom-product.index', 'uses' => 'Brand\BrandCustomProductController@index']);
    Route::get('/brand/{brand_id}/custom-product/edit/{id}', ['as' => 'brand.custom-product.edit', 'uses' => 'Brand\BrandCustomProductController@edit']);

    //销售额
    Route::get('/brand/sale-channel/modify/{id}', ['as' => 'brand.sale-channel.modify', 'uses' => 'Brand\SaleChannelController@modify']);

    //楼盘名称
    Route::get('/developer/loupan/index', ['as' => 'developer.loupan.index', 'uses' => 'Developer\LoupanController@index']);
    Route::get('/developer/loupan/edit/{id}', ['as' => 'developer.loupan.edit', 'uses' => 'Developer\LoupanController@edit']);
    //项目分类
    Route::get('/developer/project-category/index', ['as' => 'developer.project-category.index', 'uses' => 'Developer\ProjectCategoryController@index']);
    Route::get('/developer/project-category/edit/{id}', ['as' => 'developer.project-category.edit', 'uses' => 'Developer\ProjectCategoryController@edit']);

    //品类管理
    Route::get('/category/category/index', ['as' => 'category.category.index', 'uses' => 'Category\CategoryController@index']);
    Route::get('/category/category/{parent_id}/edit/{id}', ['as' => 'category.category.edit', 'uses' => 'Category\CategoryController@edit']);

    //属性管理
    Route::get('/category/attribute/index', ['as' => 'category.attribute.index', 'uses' => 'Category\AttributeController@index']);
    Route::get('/category/attribute/edit/{id}', ['as' => 'category.attribute.edit', 'uses' => 'Category\AttributeController@edit']);

    //产品
    Route::get('/product/index', ['as' => 'product.index', 'uses' => 'Product\ProductController@index']);
    Route::get('/product/edit/{id}', ['as' => 'product.edit', 'uses' => 'Product\ProductController@edit']);
    Route::get('/product/comments/{pid}', ['as' => 'product.comments', 'uses' => 'Product\ProductController@comments']);

    //文章管理
    Route::get('/information/index', ['as' => 'information.index', 'uses' => 'Information\InformationController@index']);

    Route::get('/information/edit/{id}', ['as' => 'information.edit', 'uses' => 'Information\InformationController@edit']);
    Route::get('/information/comments/{pid}', ['as' => 'information.comments', 'uses' => 'Information\InformationController@comments']);

    //关键词管理
    Route::get('/tag/index', ['as' => 'tag.index', 'uses' => 'Tag\TagController@index']);
    Route::get('/tag/edit/{id}', ['as' => 'tag.edit', 'uses' => 'Tag\TagController@edit']);

    //标签管理
    Route::get('/theme/index', ['as' => 'theme.index', 'uses' => 'Theme\ThemeController@index']);
    Route::get('/theme/edit/{id}', ['as' => 'theme.edit', 'uses' => 'Theme\ThemeController@edit']);

});
//开发商项目
require __DIR__ . '/Routes/Developer/developer.php';