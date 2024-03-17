<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Team
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/teams',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.teams',
        'uses' => 'TeamController@index',
    ])->can('index', Playground\Matrix\Models\Team::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.teams.create',
        'uses' => 'TeamController@create',
    ])->can('create', Playground\Matrix\Models\Team::class);

    Route::get('/edit/{team}', [
        'as' => 'playground.matrix.api.teams.edit',
        'uses' => 'TeamController@edit',
    ])->whereUuid('team')
        ->can('edit', 'team');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.teams.go',
    //     'uses' => 'TeamController@go',
    // ]);

    Route::get('/{team}', [
        'as' => 'playground.matrix.api.teams.show',
        'uses' => 'TeamController@show',
    ])->whereUuid('team')
        ->can('detail', 'team');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.teams.slug',
    //     'uses' => 'TeamController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.teams.store',
    //     'uses' => 'TeamController@store',
    // ])->can('store', \Playground\Matrix\Models\Team::class);

    // API

    Route::put('/lock/{team}', [
        'as' => 'playground.matrix.api.teams.lock',
        'uses' => 'TeamController@lock',
    ])->whereUuid('team')
        ->can('lock', 'team');

    Route::delete('/lock/{team}', [
        'as' => 'playground.matrix.api.teams.unlock',
        'uses' => 'TeamController@unlock',
    ])->whereUuid('team')
        ->can('unlock', 'team');

    Route::delete('/{team}', [
        'as' => 'playground.matrix.api.teams.destroy',
        'uses' => 'TeamController@destroy',
    ])->whereUuid('team')
        ->can('delete', 'team')
        ->withTrashed();

    Route::put('/restore/{team}', [
        'as' => 'playground.matrix.api.teams.restore',
        'uses' => 'TeamController@restore',
    ])->whereUuid('team')
        ->can('restore', 'team')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.teams.post',
        'uses' => 'TeamController@store',
    ])->can('store', Playground\Matrix\Models\Team::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.teams.put',
    //     'uses' => 'TeamController@store',
    // ])->can('store', \Playground\Matrix\Models\Team::class);
    //
    // Route::put('/{team}', [
    //     'as'   => 'playground.matrix.api.teams.put.id',
    //     'uses' => 'TeamController@store',
    // ])->whereUuid('team')->can('update', 'team');

    Route::patch('/{team}', [
        'as' => 'playground.matrix.api.teams.patch',
        'uses' => 'TeamController@update',
    ])->whereUuid('team')->can('update', 'team');
});
