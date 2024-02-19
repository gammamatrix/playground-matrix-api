<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Backlog
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/backlogs',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.backlogs',
        'uses' => 'BacklogController@index',
    ])->can('index', Playground\Matrix\Models\Backlog::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.backlogs.create',
        'uses' => 'BacklogController@create',
    ])->can('create', Playground\Matrix\Models\Backlog::class);

    Route::get('/edit/{backlog}', [
        'as' => 'playground.matrix.api.backlogs.edit',
        'uses' => 'BacklogController@edit',
    ])->whereUuid('backlog')
        ->can('edit', 'backlog');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.backlogs.go',
    //     'uses' => 'BacklogController@go',
    // ]);

    Route::get('/{backlog}', [
        'as' => 'playground.matrix.api.backlogs.show',
        'uses' => 'BacklogController@show',
    ])->whereUuid('backlog')
        ->can('detail', 'backlog');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.backlogs.slug',
    //     'uses' => 'BacklogController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.backlogs.store',
    //     'uses' => 'BacklogController@store',
    // ])->can('store', \Playground\Matrix\Models\Backlog::class);

    // API

    Route::put('/lock/{backlog}', [
        'as' => 'playground.matrix.api.backlogs.lock',
        'uses' => 'BacklogController@lock',
    ])->whereUuid('backlog')
        ->can('lock', 'backlog');

    Route::delete('/lock/{backlog}', [
        'as' => 'playground.matrix.api.backlogs.unlock',
        'uses' => 'BacklogController@unlock',
    ])->whereUuid('backlog')
        ->can('unlock', 'backlog');

    Route::delete('/{backlog}', [
        'as' => 'playground.matrix.api.backlogs.destroy',
        'uses' => 'BacklogController@destroy',
    ])->whereUuid('backlog')
        ->can('delete', 'backlog')
        ->withTrashed();

    Route::put('/restore/{backlog}', [
        'as' => 'playground.matrix.api.backlogs.restore',
        'uses' => 'BacklogController@restore',
    ])->whereUuid('backlog')
        ->can('restore', 'backlog')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.backlogs.post',
        'uses' => 'BacklogController@store',
    ])->can('store', Playground\Matrix\Models\Backlog::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.backlogs.put',
    //     'uses' => 'BacklogController@store',
    // ])->can('store', \Playground\Matrix\Models\Backlog::class);
    //
    // Route::put('/{backlog}', [
    //     'as'   => 'playground.matrix.api.backlogs.put.id',
    //     'uses' => 'BacklogController@store',
    // ])->whereUuid('backlog')->can('update', 'backlog');

    Route::patch('/{backlog}', [
        'as' => 'playground.matrix.api.backlogs.patch',
        'uses' => 'BacklogController@update',
    ])->whereUuid('backlog')->can('update', 'backlog');
});
