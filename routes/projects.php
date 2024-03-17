<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Project
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/projects',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.projects',
        'uses' => 'ProjectController@index',
    ])->can('index', Playground\Matrix\Models\Project::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.projects.create',
        'uses' => 'ProjectController@create',
    ])->can('create', Playground\Matrix\Models\Project::class);

    Route::get('/edit/{project}', [
        'as' => 'playground.matrix.api.projects.edit',
        'uses' => 'ProjectController@edit',
    ])->whereUuid('project')
        ->can('edit', 'project');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.projects.go',
    //     'uses' => 'ProjectController@go',
    // ]);

    Route::get('/{project}', [
        'as' => 'playground.matrix.api.projects.show',
        'uses' => 'ProjectController@show',
    ])->whereUuid('project')
        ->can('detail', 'project');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.projects.slug',
    //     'uses' => 'ProjectController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.projects.store',
    //     'uses' => 'ProjectController@store',
    // ])->can('store', \Playground\Matrix\Models\Project::class);

    // API

    Route::put('/lock/{project}', [
        'as' => 'playground.matrix.api.projects.lock',
        'uses' => 'ProjectController@lock',
    ])->whereUuid('project')
        ->can('lock', 'project');

    Route::delete('/lock/{project}', [
        'as' => 'playground.matrix.api.projects.unlock',
        'uses' => 'ProjectController@unlock',
    ])->whereUuid('project')
        ->can('unlock', 'project');

    Route::delete('/{project}', [
        'as' => 'playground.matrix.api.projects.destroy',
        'uses' => 'ProjectController@destroy',
    ])->whereUuid('project')
        ->can('delete', 'project')
        ->withTrashed();

    Route::put('/restore/{project}', [
        'as' => 'playground.matrix.api.projects.restore',
        'uses' => 'ProjectController@restore',
    ])->whereUuid('project')
        ->can('restore', 'project')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.projects.post',
        'uses' => 'ProjectController@store',
    ])->can('store', Playground\Matrix\Models\Project::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.projects.put',
    //     'uses' => 'ProjectController@store',
    // ])->can('store', \Playground\Matrix\Models\Project::class);
    //
    // Route::put('/{project}', [
    //     'as'   => 'playground.matrix.api.projects.put.id',
    //     'uses' => 'ProjectController@store',
    // ])->whereUuid('project')->can('update', 'project');

    Route::patch('/{project}', [
        'as' => 'playground.matrix.api.projects.patch',
        'uses' => 'ProjectController@update',
    ])->whereUuid('project')->can('update', 'project');
});
