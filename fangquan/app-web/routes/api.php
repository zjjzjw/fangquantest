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

// 登录状态
Route::group([], function () {
    //获取开发商项目联系人
    Route::get('developer/developer-project-contact',
        ['as' => 'developer.developer-project-contact', 'uses' => 'Api\Developer\DeveloperProjectContactController@index']
    );
    //获取供应商联系人
    Route::get('provider/provider-contact',
        ['as' => 'provider.provider-contact', 'uses' => 'Api\Provider\ProviderContactController@index']
    );

    //收藏/取消收藏项目
    Route::post('personal/collection/collection-project/store/{id}',
        ['as' => 'personal.collection.collection-project.store', 'uses' => 'Api\Personal\Collection\DeveloperProjectFavoriteController@store']
    );
    Route::post('personal/collection/collection-project/delete/{id}',
        ['as' => 'personal.collection.collection-project.delete', 'uses' => 'Api\Personal\Collection\DeveloperProjectFavoriteController@delete']
    );
    //收藏/取消收藏供应商
    Route::post('personal/collection/collection-provider/store/{id}',
        ['as' => 'personal.collection.collection-provider.store', 'uses' => 'Api\Personal\Collection\ProviderFavoriteController@store']
    );
    Route::post('personal/collection/collection-provider/delete/{id}',
        ['as' => 'personal.collection.collection-provider.delete', 'uses' => 'Api\Personal\Collection\ProviderFavoriteController@delete']
    );
    //收藏/取消收藏产品
    Route::post('personal/collection/collection-product/store/{id}',
        ['as' => 'personal.collection.collection-product.store', 'uses' => 'Api\Personal\Collection\ProviderProductFavoriteController@store']
    );
    Route::post('personal/collection/collection-product/delete/{id}',
        ['as' => 'personal.collection.collection-product.delete', 'uses' => 'Api\Personal\Collection\ProviderProductFavoriteController@delete']
    );
    //收藏/取消收藏方案
    Route::post('personal/collection/collection-scheme/store/{id}',
        ['as' => 'personal.collection.collection-scheme.store', 'uses' => 'Api\Personal\Collection\ProductProgrammeFavoriteController@store']
    );
    Route::post('personal/collection/collection-scheme/delete/{id}',
        ['as' => 'personal.collection.collection-scheme.delete', 'uses' => 'Api\Personal\Collection\ProductProgrammeFavoriteController@delete']
    );
});

Route::group([], function () {

    Route::post('account/login',
        ['as' => 'account.login', 'uses' => 'Api\Account\LoginController@login']);

    Route::post('account/mobile-register',
        ['as' => 'account.mobile-register', 'uses' => 'Api\Account\MobileRegisterController@index']);

    Route::post('account/verify-code',
        ['as' => 'account.verify-code', 'uses' => 'Api\Account\VerifyCodeController@index']);

    Route::post('account/retrieve-password-by-phone',
        ['as' => 'account.retrieve-password-by-phone', 'uses' => 'Api\Account\RetrievePasswordByPhoneController@index']);

    //修改密码
    Route::post('account/modify-password',
        ['as' => 'account.modify-password', 'uses' => 'Api\Account\LoginController@modifyPassword']
    );

    //修改昵称
    Route::post('account/modify-nickname',
        ['as' => 'account.modify-nickname', 'uses' => 'Api\Account\LoginController@modifyNickName']
    );
    //绑定手机号
    Route::post('account/bind-phone',
        ['as' => 'account.bind-phone', 'uses' => 'Api\Account\BindPhoneController@index']);

    //设为已读
    Route::post('msg/set-read/{msg_id}',
        ['as' => 'msg.set-read', 'uses' => 'Api\Msg\UserMsgController@setRead']
    );

    //收藏项目
    Route::post('developer/developer-project/collect',
        ['as' => 'developer.developer-project.collect', 'uses' => 'Api\Developer\DeveloperProjectController@collect']);

    //取消收藏
    Route::post('developer/developer-project/cancel',
        ['as' => 'developer.developer-project.cancel', 'uses' => 'Api\Developer\DeveloperProjectController@cancel']);


    Route::post('fq-user/fq-user-feedback/store/{id}',
        ['as' => 'fq-user.fq-user-feedback.store', 'uses' => 'Api\FqUser\FqUserFeedbackController@store']
    );

    Route::get('content/content/get-content/{type}',
        ['as' => 'content.content.get-content', 'uses' => 'Api\Content\ContentController@getContentList']
    );

    Route::get('/exhibition/flashback/allaudio/{page}', ['as' => 'api.exhibition.flashback.allaudio', 'uses' => 'Api\Exhibition\ExhibitionController@allAudios']);

    Route::get('/exhibition/result/{page}', ['as' => 'api.exhibition.result', 'uses' => 'Api\Exhibition\ExhibitionController@allResult']);

    Route::get('/review/list/{page}', ['as' => 'api.review.list', 'uses' => 'Api\Review\ReviewController@reviewList']);

});


//外部调用API
Route::group([], function () {
    Route::get('/resource/list', ['as' => 'api.resource.list', 'uses' => 'Api\Resource\ResourceController@list']);
});

