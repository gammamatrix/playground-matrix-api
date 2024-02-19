<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Source
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/sources',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.sources',
        'uses' => 'SourceController@index',
    ])->can('index', Playground\Matrix\Models\Source::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.sources.create',
        'uses' => 'SourceController@create',
    ])->can('create', Playground\Matrix\Models\Source::class);

    Route::get('/edit/{source}', [
        'as' => 'playground.matrix.api.sources.edit',
        'uses' => 'SourceController@edit',
    ])->whereUuid('source')
        ->can('edit', 'source');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.sources.go',
    //     'uses' => 'SourceController@go',
    // ]);

    Route::get('/{source}', [
        'as' => 'playground.matrix.api.sources.show',
        'uses' => 'SourceController@show',
    ])->whereUuid('source')
        ->can('detail', 'source');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.sources.slug',
    //     'uses' => 'SourceController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.sources.store',
    //     'uses' => 'SourceController@store',
    // ])->can('store', \Playground\Matrix\Models\Source::class);

    // API

    Route::put('/lock/{source}', [
        'as' => 'playground.matrix.api.sources.lock',
        'uses' => 'SourceController@lock',
    ])->whereUuid('source')
        ->can('lock', 'source');

    Route::delete('/lock/{source}', [
        'as' => 'playground.matrix.api.sources.unlock',
        'uses' => 'SourceController@unlock',
    ])->whereUuid('source')
        ->can('unlock', 'source');

    Route::delete('/{source}', [
        'as' => 'playground.matrix.api.sources.destroy',
        'uses' => 'SourceController@destroy',
    ])->whereUuid('source')
        ->can('delete', 'source')
        ->withTrashed();

    Route::put('/restore/{source}', [
        'as' => 'playground.matrix.api.sources.restore',
        'uses' => 'SourceController@restore',
    ])->whereUuid('source')
        ->can('restore', 'source')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.sources.post',
        'uses' => 'SourceController@store',
    ])->can('store', Playground\Matrix\Models\Source::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.sources.put',
    //     'uses' => 'SourceController@store',
    // ])->can('store', \Playground\Matrix\Models\Source::class);
    //
    // Route::put('/{source}', [
    //     'as'   => 'playground.matrix.api.sources.put.id',
    //     'uses' => 'SourceController@store',
    // ])->whereUuid('source')->can('update', 'source');

    Route::patch('/{source}', [
        'as' => 'playground.matrix.api.sources.patch',
        'uses' => 'SourceController@update',
    ])->whereUuid('source')->can('update', 'source');
});
