<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Tag
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/tags',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.tags',
        'uses' => 'TagController@index',
    ])->can('index', Playground\Matrix\Models\Tag::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.tags.create',
        'uses' => 'TagController@create',
    ])->can('create', Playground\Matrix\Models\Tag::class);

    Route::get('/edit/{tag}', [
        'as' => 'playground.matrix.api.tags.edit',
        'uses' => 'TagController@edit',
    ])->whereUuid('tag')
        ->can('edit', 'tag');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.tags.go',
    //     'uses' => 'TagController@go',
    // ]);

    Route::get('/{tag}', [
        'as' => 'playground.matrix.api.tags.show',
        'uses' => 'TagController@show',
    ])->whereUuid('tag')
        ->can('detail', 'tag');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.tags.slug',
    //     'uses' => 'TagController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.tags.store',
    //     'uses' => 'TagController@store',
    // ])->can('store', \Playground\Matrix\Models\Tag::class);

    // API

    Route::put('/lock/{tag}', [
        'as' => 'playground.matrix.api.tags.lock',
        'uses' => 'TagController@lock',
    ])->whereUuid('tag')
        ->can('lock', 'tag');

    Route::delete('/lock/{tag}', [
        'as' => 'playground.matrix.api.tags.unlock',
        'uses' => 'TagController@unlock',
    ])->whereUuid('tag')
        ->can('unlock', 'tag');

    Route::delete('/{tag}', [
        'as' => 'playground.matrix.api.tags.destroy',
        'uses' => 'TagController@destroy',
    ])->whereUuid('tag')
        ->can('delete', 'tag')
        ->withTrashed();

    Route::put('/restore/{tag}', [
        'as' => 'playground.matrix.api.tags.restore',
        'uses' => 'TagController@restore',
    ])->whereUuid('tag')
        ->can('restore', 'tag')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.tags.post',
        'uses' => 'TagController@store',
    ])->can('store', Playground\Matrix\Models\Tag::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.tags.put',
    //     'uses' => 'TagController@store',
    // ])->can('store', \Playground\Matrix\Models\Tag::class);
    //
    // Route::put('/{tag}', [
    //     'as'   => 'playground.matrix.api.tags.put.id',
    //     'uses' => 'TagController@store',
    // ])->whereUuid('tag')->can('update', 'tag');

    Route::patch('/{tag}', [
        'as' => 'playground.matrix.api.tags.patch',
        'uses' => 'TagController@update',
    ])->whereUuid('tag')->can('update', 'tag');
});
