<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Note
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/notes',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.notes',
        'uses' => 'NoteController@index',
    ])->can('index', Playground\Matrix\Models\Note::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.notes.create',
        'uses' => 'NoteController@create',
    ])->can('create', Playground\Matrix\Models\Note::class);

    Route::get('/edit/{note}', [
        'as' => 'playground.matrix.api.notes.edit',
        'uses' => 'NoteController@edit',
    ])->whereUuid('note')
        ->can('edit', 'note');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.notes.go',
    //     'uses' => 'NoteController@go',
    // ]);

    Route::get('/{note}', [
        'as' => 'playground.matrix.api.notes.show',
        'uses' => 'NoteController@show',
    ])->whereUuid('note')
        ->can('detail', 'note');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.notes.slug',
    //     'uses' => 'NoteController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.notes.store',
    //     'uses' => 'NoteController@store',
    // ])->can('store', \Playground\Matrix\Models\Note::class);

    // API

    Route::put('/lock/{note}', [
        'as' => 'playground.matrix.api.notes.lock',
        'uses' => 'NoteController@lock',
    ])->whereUuid('note')
        ->can('lock', 'note');

    Route::delete('/lock/{note}', [
        'as' => 'playground.matrix.api.notes.unlock',
        'uses' => 'NoteController@unlock',
    ])->whereUuid('note')
        ->can('unlock', 'note');

    Route::delete('/{note}', [
        'as' => 'playground.matrix.api.notes.destroy',
        'uses' => 'NoteController@destroy',
    ])->whereUuid('note')
        ->can('delete', 'note')
        ->withTrashed();

    Route::put('/restore/{note}', [
        'as' => 'playground.matrix.api.notes.restore',
        'uses' => 'NoteController@restore',
    ])->whereUuid('note')
        ->can('restore', 'note')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.notes.post',
        'uses' => 'NoteController@store',
    ])->can('store', Playground\Matrix\Models\Note::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.notes.put',
    //     'uses' => 'NoteController@store',
    // ])->can('store', \Playground\Matrix\Models\Note::class);
    //
    // Route::put('/{note}', [
    //     'as'   => 'playground.matrix.api.notes.put.id',
    //     'uses' => 'NoteController@store',
    // ])->whereUuid('note')->can('update', 'note');

    Route::patch('/{note}', [
        'as' => 'playground.matrix.api.notes.patch',
        'uses' => 'NoteController@update',
    ])->whereUuid('note')->can('update', 'note');
});
