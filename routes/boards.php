<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Board
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/boards',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.boards',
        'uses' => 'BoardController@index',
    ])->can('index', Playground\Matrix\Models\Board::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.boards.create',
        'uses' => 'BoardController@create',
    ])->can('create', Playground\Matrix\Models\Board::class);

    Route::get('/edit/{board}', [
        'as' => 'playground.matrix.api.boards.edit',
        'uses' => 'BoardController@edit',
    ])->whereUuid('board')
        ->can('edit', 'board');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.boards.go',
    //     'uses' => 'BoardController@go',
    // ]);

    Route::get('/{board}', [
        'as' => 'playground.matrix.api.boards.show',
        'uses' => 'BoardController@show',
    ])->whereUuid('board')
        ->can('detail', 'board');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.boards.slug',
    //     'uses' => 'BoardController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.boards.store',
    //     'uses' => 'BoardController@store',
    // ])->can('store', \Playground\Matrix\Models\Board::class);

    // API

    Route::put('/lock/{board}', [
        'as' => 'playground.matrix.api.boards.lock',
        'uses' => 'BoardController@lock',
    ])->whereUuid('board')
        ->can('lock', 'board');

    Route::delete('/lock/{board}', [
        'as' => 'playground.matrix.api.boards.unlock',
        'uses' => 'BoardController@unlock',
    ])->whereUuid('board')
        ->can('unlock', 'board');

    Route::delete('/{board}', [
        'as' => 'playground.matrix.api.boards.destroy',
        'uses' => 'BoardController@destroy',
    ])->whereUuid('board')
        ->can('delete', 'board')
        ->withTrashed();

    Route::put('/restore/{board}', [
        'as' => 'playground.matrix.api.boards.restore',
        'uses' => 'BoardController@restore',
    ])->whereUuid('board')
        ->can('restore', 'board')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.boards.post',
        'uses' => 'BoardController@store',
    ])->can('store', Playground\Matrix\Models\Board::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.boards.put',
    //     'uses' => 'BoardController@store',
    // ])->can('store', \Playground\Matrix\Models\Board::class);
    //
    // Route::put('/{board}', [
    //     'as'   => 'playground.matrix.api.boards.put.id',
    //     'uses' => 'BoardController@store',
    // ])->whereUuid('board')->can('update', 'board');

    Route::patch('/{board}', [
        'as' => 'playground.matrix.api.boards.patch',
        'uses' => 'BoardController@update',
    ])->whereUuid('board')->can('update', 'board');
});
