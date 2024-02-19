<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Milestone
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/milestones',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.milestones',
        'uses' => 'MilestoneController@index',
    ])->can('index', Playground\Matrix\Models\Milestone::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.milestones.create',
        'uses' => 'MilestoneController@create',
    ])->can('create', Playground\Matrix\Models\Milestone::class);

    Route::get('/edit/{milestone}', [
        'as' => 'playground.matrix.api.milestones.edit',
        'uses' => 'MilestoneController@edit',
    ])->whereUuid('milestone')
        ->can('edit', 'milestone');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.milestones.go',
    //     'uses' => 'MilestoneController@go',
    // ]);

    Route::get('/{milestone}', [
        'as' => 'playground.matrix.api.milestones.show',
        'uses' => 'MilestoneController@show',
    ])->whereUuid('milestone')
        ->can('detail', 'milestone');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.milestones.slug',
    //     'uses' => 'MilestoneController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.milestones.store',
    //     'uses' => 'MilestoneController@store',
    // ])->can('store', \Playground\Matrix\Models\Milestone::class);

    // API

    Route::put('/lock/{milestone}', [
        'as' => 'playground.matrix.api.milestones.lock',
        'uses' => 'MilestoneController@lock',
    ])->whereUuid('milestone')
        ->can('lock', 'milestone');

    Route::delete('/lock/{milestone}', [
        'as' => 'playground.matrix.api.milestones.unlock',
        'uses' => 'MilestoneController@unlock',
    ])->whereUuid('milestone')
        ->can('unlock', 'milestone');

    Route::delete('/{milestone}', [
        'as' => 'playground.matrix.api.milestones.destroy',
        'uses' => 'MilestoneController@destroy',
    ])->whereUuid('milestone')
        ->can('delete', 'milestone')
        ->withTrashed();

    Route::put('/restore/{milestone}', [
        'as' => 'playground.matrix.api.milestones.restore',
        'uses' => 'MilestoneController@restore',
    ])->whereUuid('milestone')
        ->can('restore', 'milestone')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.milestones.post',
        'uses' => 'MilestoneController@store',
    ])->can('store', Playground\Matrix\Models\Milestone::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.milestones.put',
    //     'uses' => 'MilestoneController@store',
    // ])->can('store', \Playground\Matrix\Models\Milestone::class);
    //
    // Route::put('/{milestone}', [
    //     'as'   => 'playground.matrix.api.milestones.put.id',
    //     'uses' => 'MilestoneController@store',
    // ])->whereUuid('milestone')->can('update', 'milestone');

    Route::patch('/{milestone}', [
        'as' => 'playground.matrix.api.milestones.patch',
        'uses' => 'MilestoneController@update',
    ])->whereUuid('milestone')->can('update', 'milestone');
});
