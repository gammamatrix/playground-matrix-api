<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Matrix\Models\Matrix;

/*
|--------------------------------------------------------------------------
| Matrix API Routes: Matrix
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/matrix',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {

    Route::get('/{matrix:slug}', [
        'as' => 'playground.matrix.api.matrices.slug',
        'uses' => 'MatrixController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/matrix/matrices',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.matrices',
        'uses' => 'MatrixController@index',
    ])->can('index', Matrix::class);

    Route::post('/index', [
        'as' => 'playground.matrix.api.matrices.index',
        'uses' => 'MatrixController@index',
    ])->can('index', Matrix::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.matrices.create',
        'uses' => 'MatrixController@create',
    ])->can('create', Matrix::class);

    Route::get('/edit/{matrix}', [
        'as' => 'playground.matrix.api.matrices.edit',
        'uses' => 'MatrixController@edit',
    ])->whereUuid('matrix')->can('edit', 'matrix');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.matrix.api.matrices.go',
    //     'uses' => 'MatrixController@go',
    // ]);

    Route::get('/{matrix}', [
        'as' => 'playground.matrix.api.matrices.show',
        'uses' => 'MatrixController@show',
    ])->whereUuid('matrix')->can('detail', 'matrix')->withTrashed();

    // API

    Route::put('/lock/{matrix}', [
        'as' => 'playground.matrix.api.matrices.lock',
        'uses' => 'MatrixController@lock',
    ])->whereUuid('matrix')->can('lock', 'matrix');

    Route::delete('/lock/{matrix}', [
        'as' => 'playground.matrix.api.matrices.unlock',
        'uses' => 'MatrixController@unlock',
    ])->whereUuid('matrix')->can('unlock', 'matrix');

    Route::delete('/{matrix}', [
        'as' => 'playground.matrix.api.matrices.destroy',
        'uses' => 'MatrixController@destroy',
    ])->whereUuid('matrix')->can('delete', 'matrix')->withTrashed();

    Route::put('/restore/{matrix}', [
        'as' => 'playground.matrix.api.matrices.restore',
        'uses' => 'MatrixController@restore',
    ])->whereUuid('matrix')->can('restore', 'matrix')->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.matrices.post',
        'uses' => 'MatrixController@store',
    ])->can('store', Matrix::class);

    // Route::put('/', [
    //     'as' => 'playground.matrix.api.matrices.put',
    //     'uses' => 'MatrixController@store',
    // ])->can('store', Playground\Matrix\Models\Matrix::class);
    //
    // Route::put('/{matrix}', [
    //     'as' => 'playground.matrix.api.matrices.put.id',
    //     'uses' => 'MatrixController@store',
    // ])->whereUuid('matrix')->can('update', 'matrix');

    Route::patch('/{matrix}', [
        'as' => 'playground.matrix.api.matrices.patch',
        'uses' => 'MatrixController@update',
    ])->whereUuid('matrix')->can('update', 'matrix');
});
