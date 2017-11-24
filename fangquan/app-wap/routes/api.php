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
    Route::post('/exhibition/user-answer/store/{id}', ['as' => 'api.exhibition.user-answer.store', 'uses' => 'Api\Exhibition\UserAnswerController@store']);

    Route::post('/exhibition/user-answer/time', ['as' => 'api.exhibition.user-answer.time', 'uses' => 'Api\Exhibition\UserAnswerController@time']);

    Route::post('/exhibition/user-info/store/{id}', ['as' => 'api.exhibition.user-info.store', 'uses' => 'Api\Exhibition\UserInfoController@store']);

    Route::get('/exhibition/flashback/allaudio/{page}', ['as' => 'api.exhibition.flashback.allaudio', 'uses' => 'Api\Exhibition\ExhibitionH5Controller@allAudios']);

    Route::get('/review/list/{page}', ['as' => 'api.review.list', 'uses' => 'Api\Review\ReviewController@list']);

    Route::get('/exhibition/result/{page}', ['as' => 'api.exhibition.result', 'uses' => 'Api\Exhibition\ExhibitionH5Controller@allResult']);

    Route::get('/exhibition/developer/list-more/{page}', ['as' => 'api.exhibition.developer.list-more', 'uses' => 'Api\Exhibition\DeveloperController@developerListMore']);

    Route::get('/exhibition/developer-project/list', ['as' => 'api.exhibition.developer-project.list', 'uses' => 'Api\Exhibition\DeveloperProjectController@developerProjectListMore']);

    Route::get('/exhibition/provider/list', ['as' => 'api.exhibition.provider.list', 'uses' => 'Api\Exhibition\ProviderController@providerListMore']);

});
