<?php
Route::group(['middleware' => 'guest'], function () {

    //开发商项目列表
    Route::get('/developer/{developer_id}/developer-project/index',
        ['as' => 'developer.developer-project.index', 'uses' => 'Developer\DeveloperProjectController@index']);

    Route::get('/developer/{developer_id}/developer-project/edit/{id}',
        ['as' => 'developer.developer-project.edit', 'uses' => 'Developer\DeveloperProjectController@edit']);

    //开发商
    Route::get('/developer/developer/index',
        ['as' => 'developer.developer.index', 'uses' => 'Developer\DeveloperController@index']);

    Route::get('/developer/developer/edit/{id}',
        ['as' => 'developer.developer.edit', 'uses' => 'Developer\DeveloperController@edit']);

    //项目联系人
    Route::get('/developer/{project_id}/developer-project-contact/index',
        ['as' => 'developer.developer-project-contact.index', 'uses' => 'Developer\DeveloperProjectContactController@index']);

    Route::get('/developer/{project_id}/developer-project-contact/edit/{id}',
        ['as' => 'developer.developer-project-contact.edit', 'uses' => 'Developer\DeveloperProjectContactController@edit']);

    //项目阶段
    Route::get('/developer/{project_id}/developer-project-stage-time/index',
        ['as' => 'developer.developer-project-stage-time.index', 'uses' => 'Developer\DeveloperProjectStageTimeController@index']);

    Route::get('/developer/{project_id}/developer-project-stage-time/edit/{id}',
        ['as' => 'developer.developer-project-stage-time.edit', 'uses' => 'Developer\DeveloperProjectStageTimeController@edit']);
});