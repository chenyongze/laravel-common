<?php

Route::group([
    'middleware' => ['auth:api', 'admin'],
    'namespace' => 'Api',
], function () {
    Route::get('statistics', 'HomeController@statistics');

    Route::resource('user', 'UserController', ['except' => ['create', 'show']]);
    Route::post('/user/{id}/status', 'UserController@status');

    Route::resource('article', 'ArticleController');

    Route::resource('category', 'CategoryController', ['except' => ['create', 'show']]);
    Route::get('/categories', 'CategoryController@getList');
    Route::post('/category/{id}/status', 'CategoryController@status');

    Route::resource('discussion', 'DiscussionController', ['except' => ['create', 'show']]);
    Route::post('/discussion/{id}/status', 'DiscussionController@status');

    Route::resource('comment', 'CommentController', ['except' => ['create']]);

    Route::resource('tag', 'TagController', ['except' => ['create', 'show']]);
    Route::post('/tag/{id}/status', 'TagController@status');

    Route::resource('link', 'LinkController', ['except' => ['create', 'show']]);
    Route::post('/link/{id}/status', 'LinkController@status');

    Route::get('visitor', 'VisitorController@index');

    Route::get('upload', 'UploadController@index');
    Route::post('upload', 'UploadController@uploadFile');
    Route::post('upload/path', 'UploadController@uploadFileByPath');
    Route::post('folder', 'UploadController@createFolder');
    Route::post('folder/delete', 'UploadController@deleteFolder');
    Route::post('file/delete', 'UploadController@deleteFile');

    Route::get('system', 'SystemController@getSystemInfo');
});

Route::group([
    'namespace' => 'Api',
], function () {
    Route::get('commentable/{commentableId}/comment', 'CommentController@show');
    Route::post('comments', 'CommentController@store')->middleware('auth:api');
    Route::delete('comments/{id}', 'CommentController@destroy')->middleware('auth:api');
    Route::get('tags', 'TagController@getList');
});

//test
//Route::get('abc/bb/{id}', function () {
//    return [1, 2, 3];
//});

Route::group([
    'namespace' => 'Api',
], function () {
    Route::get('abc/{id}/user_id','TestController@abc');
    Route::get('caiji','TestController@caiji');
    Route::get('pinyin','TestController@pinyin');
    Route::get('username','TestController@userName');
    Route::get('cacheInc','TestController@cacheInc');
    Route::get('collect','TestController@collect');
    Route::get('db','TestController@db');
    Route::get('crypt','TestController@crypt');
    Route::get('alipayApp','TestController@alipayApp');
    Route::get('alipayWap','TestController@alipayWap');
    Route::get('wechatPayApp','TestController@wechatPayApp');
    Route::get('wechatNative','TestController@wechatNative');
    Route::get('qiniu','TestController@qiniu');
});


