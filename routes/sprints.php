<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Sprint
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/sprints',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.sprints',
        'uses' => 'SprintController@index',
    ])->can('index', Playground\Matrix\Models\Sprint::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.sprints.create',
        'uses' => 'SprintController@create',
    ])->can('create', Playground\Matrix\Models\Sprint::class);

    Route::get('/edit/{sprint}', [
        'as' => 'playground.matrix.api.sprints.edit',
        'uses' => 'SprintController@edit',
    ])->whereUuid('sprint')
        ->can('edit', 'sprint');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.sprints.go',
    //     'uses' => 'SprintController@go',
    // ]);

    Route::get('/{sprint}', [
        'as' => 'playground.matrix.api.sprints.show',
        'uses' => 'SprintController@show',
    ])->whereUuid('sprint')
        ->can('detail', 'sprint');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.sprints.slug',
    //     'uses' => 'SprintController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.sprints.store',
    //     'uses' => 'SprintController@store',
    // ])->can('store', \Playground\Matrix\Models\Sprint::class);

    // API

    Route::put('/lock/{sprint}', [
        'as' => 'playground.matrix.api.sprints.lock',
        'uses' => 'SprintController@lock',
    ])->whereUuid('sprint')
        ->can('lock', 'sprint');

    Route::delete('/lock/{sprint}', [
        'as' => 'playground.matrix.api.sprints.unlock',
        'uses' => 'SprintController@unlock',
    ])->whereUuid('sprint')
        ->can('unlock', 'sprint');

    Route::delete('/{sprint}', [
        'as' => 'playground.matrix.api.sprints.destroy',
        'uses' => 'SprintController@destroy',
    ])->whereUuid('sprint')
        ->can('delete', 'sprint')
        ->withTrashed();

    Route::put('/restore/{sprint}', [
        'as' => 'playground.matrix.api.sprints.restore',
        'uses' => 'SprintController@restore',
    ])->whereUuid('sprint')
        ->can('restore', 'sprint')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.sprints.post',
        'uses' => 'SprintController@store',
    ])->can('store', Playground\Matrix\Models\Sprint::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.sprints.put',
    //     'uses' => 'SprintController@store',
    // ])->can('store', \Playground\Matrix\Models\Sprint::class);
    //
    // Route::put('/{sprint}', [
    //     'as'   => 'playground.matrix.api.sprints.put.id',
    //     'uses' => 'SprintController@store',
    // ])->whereUuid('sprint')->can('update', 'sprint');

    Route::patch('/{sprint}', [
        'as' => 'playground.matrix.api.sprints.patch',
        'uses' => 'SprintController@update',
    ])->whereUuid('sprint')->can('update', 'sprint');
});
