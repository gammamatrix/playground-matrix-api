<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Flow
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/flows',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.flows',
        'uses' => 'FlowController@index',
    ])->can('index', Playground\Matrix\Models\Flow::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.flows.create',
        'uses' => 'FlowController@create',
    ])->can('create', Playground\Matrix\Models\Flow::class);

    Route::get('/edit/{flow}', [
        'as' => 'playground.matrix.api.flows.edit',
        'uses' => 'FlowController@edit',
    ])->whereUuid('flow')
        ->can('edit', 'flow');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.flows.go',
    //     'uses' => 'FlowController@go',
    // ]);

    Route::get('/{flow}', [
        'as' => 'playground.matrix.api.flows.show',
        'uses' => 'FlowController@show',
    ])->whereUuid('flow')
        ->can('detail', 'flow');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.flows.slug',
    //     'uses' => 'FlowController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.flows.store',
    //     'uses' => 'FlowController@store',
    // ])->can('store', \Playground\Matrix\Models\Flow::class);

    // API

    Route::put('/lock/{flow}', [
        'as' => 'playground.matrix.api.flows.lock',
        'uses' => 'FlowController@lock',
    ])->whereUuid('flow')
        ->can('lock', 'flow');

    Route::delete('/lock/{flow}', [
        'as' => 'playground.matrix.api.flows.unlock',
        'uses' => 'FlowController@unlock',
    ])->whereUuid('flow')
        ->can('unlock', 'flow');

    Route::delete('/{flow}', [
        'as' => 'playground.matrix.api.flows.destroy',
        'uses' => 'FlowController@destroy',
    ])->whereUuid('flow')
        ->can('delete', 'flow')
        ->withTrashed();

    Route::put('/restore/{flow}', [
        'as' => 'playground.matrix.api.flows.restore',
        'uses' => 'FlowController@restore',
    ])->whereUuid('flow')
        ->can('restore', 'flow')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.flows.post',
        'uses' => 'FlowController@store',
    ])->can('store', Playground\Matrix\Models\Flow::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.flows.put',
    //     'uses' => 'FlowController@store',
    // ])->can('store', \Playground\Matrix\Models\Flow::class);
    //
    // Route::put('/{flow}', [
    //     'as'   => 'playground.matrix.api.flows.put.id',
    //     'uses' => 'FlowController@store',
    // ])->whereUuid('flow')->can('update', 'flow');

    Route::patch('/{flow}', [
        'as' => 'playground.matrix.api.flows.patch',
        'uses' => 'FlowController@update',
    ])->whereUuid('flow')->can('update', 'flow');
});
