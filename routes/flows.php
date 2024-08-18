<?php
/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix API Routes: Flow
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/flow',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {

    Route::get('/{flow:slug}', [
        'as' => 'playground.matrix.api.flows.slug',
        'uses' => 'FlowController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/matrix/flows',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.flows',
        'uses' => 'FlowController@index',
    ])->can('index', Playground\Matrix\Models\Flow::class);

    Route::post('/index', [
        'as' => 'playground.matrix.api.flows.index',
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
    ])->whereUuid('flow')->can('edit', 'flow');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.matrix.api.flows.go',
    //     'uses' => 'FlowController@go',
    // ]);

    Route::get('/{flow}', [
        'as' => 'playground.matrix.api.flows.show',
        'uses' => 'FlowController@show',
    ])->whereUuid('flow')->can('detail', 'flow');

    // API

    Route::put('/lock/{flow}', [
        'as' => 'playground.matrix.api.flows.lock',
        'uses' => 'FlowController@lock',
    ])->whereUuid('flow')->can('lock', 'flow');

    Route::delete('/lock/{flow}', [
        'as' => 'playground.matrix.api.flows.unlock',
        'uses' => 'FlowController@unlock',
    ])->whereUuid('flow')->can('unlock', 'flow');

    Route::delete('/{flow}', [
        'as' => 'playground.matrix.api.flows.destroy',
        'uses' => 'FlowController@destroy',
    ])->whereUuid('flow')->can('delete', 'flow')->withTrashed();

    Route::put('/restore/{flow}', [
        'as' => 'playground.matrix.api.flows.restore',
        'uses' => 'FlowController@restore',
    ])->whereUuid('flow')->can('restore', 'flow')->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.flows.post',
        'uses' => 'FlowController@store',
    ])->can('store', Playground\Matrix\Models\Flow::class);

    // Route::put('/', [
    //     'as' => 'playground.matrix.api.flows.put',
    //     'uses' => 'FlowController@store',
    // ])->can('store', Playground\Matrix\Models\Flow::class);
    //
    // Route::put('/{flow}', [
    //     'as' => 'playground.matrix.api.flows.put.id',
    //     'uses' => 'FlowController@store',
    // ])->whereUuid('flow')->can('update', 'flow');

    Route::patch('/{flow}', [
        'as' => 'playground.matrix.api.flows.patch',
        'uses' => 'FlowController@update',
    ])->whereUuid('flow')->can('update', 'flow');
});
