<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Release
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/releases',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.releases',
        'uses' => 'ReleaseController@index',
    ])->can('index', Playground\Matrix\Models\Release::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.releases.create',
        'uses' => 'ReleaseController@create',
    ])->can('create', Playground\Matrix\Models\Release::class);

    Route::get('/edit/{release}', [
        'as' => 'playground.matrix.api.releases.edit',
        'uses' => 'ReleaseController@edit',
    ])->whereUuid('release')
        ->can('edit', 'release');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.releases.go',
    //     'uses' => 'ReleaseController@go',
    // ]);

    Route::get('/{release}', [
        'as' => 'playground.matrix.api.releases.show',
        'uses' => 'ReleaseController@show',
    ])->whereUuid('release')
        ->can('detail', 'release');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.releases.slug',
    //     'uses' => 'ReleaseController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.releases.store',
    //     'uses' => 'ReleaseController@store',
    // ])->can('store', \Playground\Matrix\Models\Release::class);

    // API

    Route::put('/lock/{release}', [
        'as' => 'playground.matrix.api.releases.lock',
        'uses' => 'ReleaseController@lock',
    ])->whereUuid('release')
        ->can('lock', 'release');

    Route::delete('/lock/{release}', [
        'as' => 'playground.matrix.api.releases.unlock',
        'uses' => 'ReleaseController@unlock',
    ])->whereUuid('release')
        ->can('unlock', 'release');

    Route::delete('/{release}', [
        'as' => 'playground.matrix.api.releases.destroy',
        'uses' => 'ReleaseController@destroy',
    ])->whereUuid('release')
        ->can('delete', 'release')
        ->withTrashed();

    Route::put('/restore/{release}', [
        'as' => 'playground.matrix.api.releases.restore',
        'uses' => 'ReleaseController@restore',
    ])->whereUuid('release')
        ->can('restore', 'release')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.releases.post',
        'uses' => 'ReleaseController@store',
    ])->can('store', Playground\Matrix\Models\Release::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.releases.put',
    //     'uses' => 'ReleaseController@store',
    // ])->can('store', \Playground\Matrix\Models\Release::class);
    //
    // Route::put('/{release}', [
    //     'as'   => 'playground.matrix.api.releases.put.id',
    //     'uses' => 'ReleaseController@store',
    // ])->whereUuid('release')->can('update', 'release');

    Route::patch('/{release}', [
        'as' => 'playground.matrix.api.releases.patch',
        'uses' => 'ReleaseController@update',
    ])->whereUuid('release')->can('update', 'release');
});
