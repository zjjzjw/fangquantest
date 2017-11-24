<?php
Route::group(['middleware' => 'api'], function () {

    //开发商项目列表
    Route::post('/developer/developer-project/store/{id}',
        ['as' => 'api.developer.developer-project.store', 'uses' => 'Api\Developer\DeveloperProjectController@store']);

    Route::post('/developer/developer-project/update/{id}',
        ['as' => 'api.developer.developer-project.update', 'uses' => 'Api\Developer\DeveloperProjectController@update']);

    Route::post('/developer/developer-project/delete/{id}',
        ['as' => 'api.developer.developer-project.delete', 'uses' => 'Api\Developer\DeveloperProjectController@delete']);

    //开发商
    Route::post('/developer/developer/store/{id}',
        ['as' => 'api.developer.developer.store', 'uses' => 'Api\Developer\DeveloperController@store']);

    Route::post('/developer/developer/update/{id}',
        ['as' => 'api.developer.developer.update', 'uses' => 'Api\Developer\DeveloperController@update']);

    Route::post('/developer/developer/delete/{id}',
        ['as' => 'api.developer.developer.delete', 'uses' => 'Api\Developer\DeveloperController@delete']);


    //项目联系人
    Route::post('/developer/developer-project-contact/store/{id}',
        ['as' => 'api.developer.developer-project-contact.store', 'uses' => 'Api\Developer\DeveloperProjectContactController@store']);

    Route::post('/developer/developer-project-contact/update/{id}',
        ['as' => 'api.developer.developer-project-contact.update', 'uses' => 'Api\Developer\DeveloperProjectContactController@update']);

    Route::post('/developer/developer-project-contact/delete/{id}',
        ['as' => 'api.developer.developer-project-contact.delete', 'uses' => 'Api\Developer\DeveloperProjectContactController@delete']);

    //项目阶段时间
    Route::post('/developer/developer-project-stage-time/store/{id}',
        ['as' => 'api.developer.developer-project-stage-time.store', 'uses' => 'Api\Developer\DeveloperProjectStageTimeController@store']);

    Route::post('/developer/developer-project-stage-time/update/{id}',
        ['as' => 'api.developer.developer-project-stage-time.update', 'uses' => 'Api\Developer\DeveloperProjectStageTimeController@update']);

    Route::post('/developer/developer-project-stage-time/delete/{id}',
        ['as' => 'api.developer.developer-project-stage-time.delete', 'uses' => 'Api\Developer\DeveloperProjectStageTimeController@delete']);

});