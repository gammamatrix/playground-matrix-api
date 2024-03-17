<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Epic
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/epics',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.epics',
        'uses' => 'EpicController@index',
    ])->can('index', Playground\Matrix\Models\Epic::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.epics.create',
        'uses' => 'EpicController@create',
    ])->can('create', Playground\Matrix\Models\Epic::class);

    Route::get('/edit/{epic}', [
        'as' => 'playground.matrix.api.epics.edit',
        'uses' => 'EpicController@edit',
    ])->whereUuid('epic')
        ->can('edit', 'epic');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.epics.go',
    //     'uses' => 'EpicController@go',
    // ]);

    Route::get('/{epic}', [
        'as' => 'playground.matrix.api.epics.show',
        'uses' => 'EpicController@show',
    ])->whereUuid('epic')
        ->can('detail', 'epic');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.epics.slug',
    //     'uses' => 'EpicController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.epics.store',
    //     'uses' => 'EpicController@store',
    // ])->can('store', \Playground\Matrix\Models\Epic::class);

    // API

    Route::put('/lock/{epic}', [
        'as' => 'playground.matrix.api.epics.lock',
        'uses' => 'EpicController@lock',
    ])->whereUuid('epic')
        ->can('lock', 'epic');

    Route::delete('/lock/{epic}', [
        'as' => 'playground.matrix.api.epics.unlock',
        'uses' => 'EpicController@unlock',
    ])->whereUuid('epic')
        ->can('unlock', 'epic');

    Route::delete('/{epic}', [
        'as' => 'playground.matrix.api.epics.destroy',
        'uses' => 'EpicController@destroy',
    ])->whereUuid('epic')
        ->can('delete', 'epic')
        ->withTrashed();

    Route::put('/restore/{epic}', [
        'as' => 'playground.matrix.api.epics.restore',
        'uses' => 'EpicController@restore',
    ])->whereUuid('epic')
        ->can('restore', 'epic')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.epics.post',
        'uses' => 'EpicController@store',
    ])->can('store', Playground\Matrix\Models\Epic::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.epics.put',
    //     'uses' => 'EpicController@store',
    // ])->can('store', \Playground\Matrix\Models\Epic::class);
    //
    // Route::put('/{epic}', [
    //     'as'   => 'playground.matrix.api.epics.put.id',
    //     'uses' => 'EpicController@store',
    // ])->whereUuid('epic')->can('update', 'epic');

    Route::patch('/{epic}', [
        'as' => 'playground.matrix.api.epics.patch',
        'uses' => 'EpicController@update',
    ])->whereUuid('epic')->can('update', 'epic');
});
