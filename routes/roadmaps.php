<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Roadmap
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/roadmaps',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.roadmaps',
        'uses' => 'RoadmapController@index',
    ])->can('index', Playground\Matrix\Models\Roadmap::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.roadmaps.create',
        'uses' => 'RoadmapController@create',
    ])->can('create', Playground\Matrix\Models\Roadmap::class);

    Route::get('/edit/{roadmap}', [
        'as' => 'playground.matrix.api.roadmaps.edit',
        'uses' => 'RoadmapController@edit',
    ])->whereUuid('roadmap')
        ->can('edit', 'roadmap');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.roadmaps.go',
    //     'uses' => 'RoadmapController@go',
    // ]);

    Route::get('/{roadmap}', [
        'as' => 'playground.matrix.api.roadmaps.show',
        'uses' => 'RoadmapController@show',
    ])->whereUuid('roadmap')
        ->can('detail', 'roadmap');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.roadmaps.slug',
    //     'uses' => 'RoadmapController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.roadmaps.store',
    //     'uses' => 'RoadmapController@store',
    // ])->can('store', \Playground\Matrix\Models\Roadmap::class);

    // API

    Route::put('/lock/{roadmap}', [
        'as' => 'playground.matrix.api.roadmaps.lock',
        'uses' => 'RoadmapController@lock',
    ])->whereUuid('roadmap')
        ->can('lock', 'roadmap');

    Route::delete('/lock/{roadmap}', [
        'as' => 'playground.matrix.api.roadmaps.unlock',
        'uses' => 'RoadmapController@unlock',
    ])->whereUuid('roadmap')
        ->can('unlock', 'roadmap');

    Route::delete('/{roadmap}', [
        'as' => 'playground.matrix.api.roadmaps.destroy',
        'uses' => 'RoadmapController@destroy',
    ])->whereUuid('roadmap')
        ->can('delete', 'roadmap')
        ->withTrashed();

    Route::put('/restore/{roadmap}', [
        'as' => 'playground.matrix.api.roadmaps.restore',
        'uses' => 'RoadmapController@restore',
    ])->whereUuid('roadmap')
        ->can('restore', 'roadmap')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.roadmaps.post',
        'uses' => 'RoadmapController@store',
    ])->can('store', Playground\Matrix\Models\Roadmap::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.roadmaps.put',
    //     'uses' => 'RoadmapController@store',
    // ])->can('store', \Playground\Matrix\Models\Roadmap::class);
    //
    // Route::put('/{roadmap}', [
    //     'as'   => 'playground.matrix.api.roadmaps.put.id',
    //     'uses' => 'RoadmapController@store',
    // ])->whereUuid('roadmap')->can('update', 'roadmap');

    Route::patch('/{roadmap}', [
        'as' => 'playground.matrix.api.roadmaps.patch',
        'uses' => 'RoadmapController@update',
    ])->whereUuid('roadmap')->can('update', 'roadmap');
});
