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

Route::get('/qiniu/token', ['as' => 'qiniu.token', 'uses' => 'QiniuController@storageToken']);

Route::group(['middleware' => 'token'], function () {

    //版本android
    Route::get('android/version', ['as' => 'qiniu.token', 'uses' => 'VersionController@version']);
    //获取某一分类下面的分类列表
    Route::get('product/product-category',
        ['as' => 'product.product-category', 'uses' => 'Product\ProductCategoryController@productCategory']);
    //获取TOP5分类
    Route::get('product/product-category/top5',
        ['as' => 'product.product-category.top5', 'uses' => 'Product\ProductCategoryController@productCategoryTop5']);
    //获取一级二级分类列表
    Route::get('product/product-category/list',
        ['as' => 'product.product-category.list', 'uses' => 'Product\ProductCategoryController@productCategoryList']);
    Route::get('product/product-second-category/list',
        ['as' => 'product.product-second-category.list', 'uses' => 'Product\ProductCategoryController@productSecondCategoryList']);

});

Route::group(['middleware' => 'token'], function () {
    Route::get('provider/detail/{id}',
        ['as' => 'provider.detail', 'uses' => 'Provider\ProviderController@detail']);
    Route::get('provider/index',
        ['as' => 'provider.index', 'uses' => 'Provider\ProviderController@index']);
    Route::get('provider/company-info/{id}',
        ['as' => 'provider.company-info', 'uses' => 'Provider\ProviderController@companyInfo']);
    Route::get('provider/provider-contact/{id}',
        ['as' => 'provider.provider-contact', 'uses' => 'Provider\ProviderController@providerContact']);
    //供应商对比
    Route::get('provider/provider-contrast',
        ['as' => 'provider.provider-contrast', 'uses' => 'Provider\ProviderController@contrast']);
    //产品对比
    Route::get('provider/product-contrast',
        ['as' => 'provider.product-contrast', 'uses' => 'Provider\ProviderProductController@contrast']);

    //获取某一供应商的产品二级分类列表
    Route::get('provider/product-category/{id}',
        ['as' => 'provider.provider-category', 'uses' => 'Provider\ProviderController@providerCategory'])
        ->where('id', '[0-9]+');
    //获取某个二级分类下的供应商列表
    Route::get('provider/product-category/list',
        ['as' => 'provider.provider-category', 'uses' => 'Provider\ProviderController@categoryProvider']);
    //某个二级分类下的供应商产品列表
    Route::get('provider/category/product',
        ['as' => 'provider.category.product', 'uses' => 'Provider\ProviderController@categoryProduct']);

    //provider news
    Route::get('provider/provider-news/{id}',
        ['as' => 'provider.provider-news.index', 'uses' => 'Provider\ProviderNewsController@providerNews']);
    Route::get('provider/provider-news/detail/{id}',
        ['as' => 'provider.provider-news.detail', 'uses' => 'Provider\ProviderNewsController@detail']);

    //provider friend
    //供应商合作商列表
    Route::get('provider/provider-friend/{id}',
        ['as' => 'provider.provider-friend.index', 'uses' => 'Provider\ProviderFriendController@providerFriends']);
    //供应商合作商详情
    Route::get('provider/provider-friend/detail/{id}',
        ['as' => 'provider.provider-friend.detail', 'uses' => 'Provider\ProviderFriendController@detail']);

    //provider project
    //供应商项目列表
    Route::get('provider/provider-project/{id}',
        ['as' => 'provider.provider-project.index', 'uses' => 'Provider\ProviderProjectController@providerProjects']);
    //供应商项目详情
    Route::get('provider/provider-project/detail/{id}',
        ['as' => 'provider.provider-project.detail', 'uses' => 'Provider\ProviderProjectController@detail']);

    //provider product
    //供应商产品列表
    Route::get('provider/provider-product/{id}',
        ['as' => 'provider.provider-product.index', 'uses' => 'Provider\ProviderProductController@providerProducts']);
    //供应商产品详情
    Route::get('provider/provider-product/detail/{id}',
        ['as' => 'provider.provider-product.detail', 'uses' => 'Provider\ProviderProductController@detail']);

    //provider service network
    //服务网网点列表
    Route::get('provider/provider-service-network/{id}',
        ['as' => 'provider.provider-service-network.index', 'uses' => 'Provider\ProviderServiceNetworkController@providerServiceNetworks'])
        ->where('id', '[0-9]+');
    //服务网点详情列表
    Route::get('provider/provider-service-network/list',
        ['as' => 'provider.provider-service-network.list', 'uses' => 'Provider\ProviderServiceNetworkController@list']);
    //验厂报告列表
    Route::get('provider/provider-aduitdetails/list',
        ['as' => 'provider.provider-aduitdetails.list', 'uses' => 'Provider\ProviderAduitdetailsController@list']);
    //验厂报告列表
    Route::get('provider/provider-aduitdetails/detail/{id}',
        ['as' => 'provider.provider-aduitdetails.detail', 'uses' => 'Provider\ProviderAduitdetailsController@detail']);

    //产品组合列表页
    Route::get('provider/provider-product-programme/list/{id}',
        ['as' => 'provider.provider-product-programme.list', 'uses' => 'Provider\ProviderProductProgrammeController@programmeList']);

    Route::get('provider/provider-product-programme/detail/{id}',
        ['as' => 'provider.provider-product-programme.detail', 'uses' => 'Provider\ProviderProductProgrammeController@detail']);
    //获取某二级分类下的品牌排行榜
    Route::get('provider/brand/rank',
        ['as' => 'provider.brand.rank', 'uses' => 'Provider\ProviderController@ProviderBrandRank']);

    //工商信息
    Route::get('provider/provider-business/{id}',
        ['as' => 'provider.provider-business', 'uses' => 'Provider\ProviderBusinessController@providerBusiness']);
    //基本信息
    Route::get('provider/provider-business/basic-info/{id}',
        ['as' => 'provider.provider-business.basic-info', 'uses' => 'Provider\ProviderBusinessController@basicInfo']);
    //股东信息
    Route::get('provider/provider-business/shareholder-info/{id}',
        ['as' => 'provider.provider-business.shareholder-info', 'uses' => 'Provider\ProviderBusinessController@shareholderInfo']);
    //主要成员
    Route::get('provider/provider-business/main-person-info/{id}',
        ['as' => 'provider.provider-business.main-person-info', 'uses' => 'Provider\ProviderBusinessController@mainPersonInfo']);
    //变更记录
    Route::get('provider/provider-business/change-record-info/{id}',
        ['as' => 'provider.provider-business.change-record-info', 'uses' => 'Provider\ProviderBusinessController@changeRecordInfo']);
    //融资历史
    Route::get('provider/provider-business/financing-history-info/{id}',
        ['as' => 'provider.provider-business.financing-history-info', 'uses' => 'Provider\ProviderBusinessController@financingHistoryInfo']);
    //核心团队
    Route::get('provider/provider-business/core-team-info/{id}',
        ['as' => 'provider.provider-business.core-team-info', 'uses' => 'Provider\ProviderBusinessController@coreTeamInfo']);
    //企业业务
    Route::get('provider/provider-business/enterprise-business-info/{id}',
        ['as' => 'provider.provider-business.enterprise-business-info', 'uses' => 'Provider\ProviderBusinessController@enterpriseBusinessInfo']);
    //法律诉讼
    Route::get('provider/provider-business/legal-proceedings-info/{id}',
        ['as' => 'provider.provider-business.legal-proceedings-info', 'uses' => 'Provider\ProviderBusinessController@legalProceedingsInfo']);
    //法院公告
    Route::get('provider/provider-business/court-notice-info/{id}',
        ['as' => 'provider.provider-business.court-notice-info', 'uses' => 'Provider\ProviderBusinessController@courtNoticeInfo']);
    //失信人
    Route::get('provider/provider-business/dishonest-person-info/{id}',
        ['as' => 'provider.provider-business.dishonest-person-info', 'uses' => 'Provider\ProviderBusinessController@dishonestPersonInfo']);
    //被执行人
    Route::get('provider/provider-business/person-subjected-execution-info/{id}',
        ['as' => 'provider.provider-business.person-subjected-execution-info', 'uses' => 'Provider\ProviderBusinessController@personSubjectedExecutionInfo']);
    //行政处罚
    Route::get('provider/provider-business/administrative-sanction-info/{id}',
        ['as' => 'provider.provider-business.administrative-sanction-info', 'uses' => 'Provider\ProviderBusinessController@administrativeSanctionInfo']);
    //严重违规
    Route::get('provider/provider-business/serious-violation-info/{id}',
        ['as' => 'provider.provider-business.serious-violation-info', 'uses' => 'Provider\ProviderBusinessController@seriousViolationInfo']);
    //股权出质
    Route::get('provider/provider-business/stock-ownership-info/{id}',
        ['as' => 'provider.provider-business.stock-ownership-info', 'uses' => 'Provider\ProviderBusinessController@stockOwnershipInfo']);
    //动产抵押
    Route::get('provider/provider-business/chattel-mortgage-info/{id}',
        ['as' => 'provider.provider-business.chattel-mortgage-info', 'uses' => 'Provider\ProviderBusinessController@chattelMortgageInfo']);
    //欠税公告
    Route::get('provider/provider-business/tax-notice-info/{id}',
        ['as' => 'provider.provider-business.tax-notice-info', 'uses' => 'Provider\ProviderBusinessController@taxNoticeInfo']);
    //经营异常
    Route::get('provider/provider-business/abnormal-operation-info/{id}',
        ['as' => 'provider.provider-business.abnormal-operation-info', 'uses' => 'Provider\ProviderBusinessController@abnormalOperationInfo']);
    //税务等级
    Route::get('provider/provider-business/tax-rating-info/{id}',
        ['as' => 'provider.provider-business.tax-rating-info', 'uses' => 'Provider\ProviderBusinessController@ ']);
    //购地信息
    Route::get('provider/provider-business/purchase-information-info/{id}',
        ['as' => 'provider.provider-business.purchase-information-info', 'uses' => 'Provider\ProviderBusinessController@purchaseInformationInfo']);
    //招投标
    Route::get('provider/provider-business/bidding-info/{id}',
        ['as' => 'provider.provider-business.bidding-info', 'uses' => 'Provider\ProviderBusinessController@biddingInfo']);
    //资质证书
    Route::get('provider/provider-business/qualification-certificate-info/{id}',
        ['as' => 'provider.provider-business.qualification-certificate-info', 'uses' => 'Provider\ProviderBusinessController@qualificationCertificateInfo']);
    //商标信息
    Route::get('provider/provider-business/trademark-information-info/{id}',
        ['as' => 'provider.provider-business.trademark-information-info', 'uses' => 'Provider\ProviderBusinessController@trademarkInformationInfo']);
    //专利信息
    Route::get('provider/provider-business/patent-info/{id}',
        ['as' => 'provider.provider-business.patent-info', 'uses' => 'Provider\ProviderBusinessController@patentInfo']);

});

//收藏
Route::group(['middleware' => 'token'], function () {
    //供应商收藏
    Route::post('provider/provider-favorite',
        ['as' => 'provider.provider-favorite', 'uses' => 'Provider\ProviderFavoriteController@providerFavorite']);
    Route::get('provider/provider-favorite/list',
        ['as' => 'provider.provider-favorite.index', 'uses' => 'Provider\ProviderFavoriteController@list']);
    //供应商产品收藏
    Route::post('provider/provider-product-favorite',
        ['as' => 'provider.provider-product-favorite', 'uses' => 'Provider\ProviderProductFavoriteController@providerProductFavorite']);
    Route::get('provider/provider-product-favorite/list',
        ['as' => 'provider.provider-product-favorite.list', 'uses' => 'Provider\ProviderProductFavoriteController@list']);
    //供应商产品组合收藏
    Route::post('provider/provider-product-programme-favorite',
        ['as' => 'provider.provider-product-programme-favorite', 'uses' => 'Provider\ProviderProductProgrammeFavoriteController@providerProductProgrammeFavorite']);
    Route::get('provider/provider-product-programme-favorite/list',
        ['as' => 'provider.provider-product-programme-favorite.list', 'uses' => 'Provider\ProviderProductProgrammeFavoriteController@list']);
});


Route::group(['middleware' => 'token'], function () {
    Route::get('surport/china-area',
        ['as' => 'surport.china-area', 'uses' => 'Surport\ChinaAreaController@areaList']);
});

Route::group(['middleware' => 'token'], function () {
    Route::get('developer/project/index',
        ['as' => 'developer.project.index', 'uses' => 'Developer\DeveloperProjectController@index']);

    Route::get('developer/project/detail/{id}',
        ['as' => 'developer.project.detail', 'uses' => 'Developer\DeveloperProjectController@detail']);

    Route::get('developer/project/recommend',
        ['as' => 'developer.project.recommend', 'uses' => 'Developer\DeveloperProjectController@recommend']);

    //供应商项目阶段
    Route::get('developer/project/stage',
        ['as' => 'developer.project.stage', 'uses' => 'Developer\DeveloperProjectStageController@projectStage']);
    //供应商项目联系人列表
    Route::get('developer/project/contacts/{id}',
        ['as' => 'developer.project.contacts', 'uses' => 'Developer\DeveloperProjectContactsController@projectContacts']);
    //供应商项目收藏
    Route::post('developer/project-favorite',
        ['as' => 'developer.project-favorite', 'uses' => 'Developer\DeveloperProjectFavoriteController@projectFavorite']);
    //供应商项目收藏列表
    Route::get('developer/project-favorite/list',
        ['as' => 'developer.project-favorite.list', 'uses' => 'Developer\DeveloperProjectFavoriteController@list']);

    //找项目筛选选项
    Route::get('developer/project/filter-items',
        ['as' => 'developer.project.filter-items', 'uses' => 'Developer\DeveloperProjectController@projectFilterItems']);

    Route::post('user/feedback',
        ['as' => 'user.feedback', 'uses' => 'Account\UserController@feedback']);

    Route::get('user/info',
        ['as' => 'user.info', 'uses' => 'FqUser\InfoController@index']);

    Route::post('user/edit',
        ['as' => 'user.edit', 'uses' => 'FqUser\InfoController@edit']);

    Route::post('account/bind-phone',
        ['as' => 'account.bind-phone', 'uses' => 'Account\BindPhoneController@index']);
});

Route::group([''], function () {
    Route::post('account/login',
        ['as' => 'account.login', 'uses' => 'Account\LoginController@index']);

    Route::post('account/verify-code',
        ['as' => 'account.verify-code', 'uses' => 'Account\VerifyCodeController@index']);

    Route::post('account/mobile-register',
        ['as' => 'account.mobile-register', 'uses' => 'Account\MobileRegisterController@index']);

    Route::post('account/third-party-register',
        ['as' => 'account.third-party-register', 'uses' => 'Account\ThirdPartyRegisterController@index']);

    Route::get('account/check-third-party',
        ['as' => 'account.check-third-party', 'uses' => 'Account\CheckThirdPartyController@index']);

    Route::post('account/config',
        ['as' => 'account.config', 'uses' => 'Account\ConfigController@index']);

    Route::post('account/retrieve-password-by-phone',
        ['as' => 'account.retrieve-password-by-phone', 'uses' => 'Account\RetrievePasswordByPhoneController@index']);


});
