<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Matrix Routes: Ticket
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/tickets',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.matrix.api.tickets',
        'uses' => 'TicketController@index',
    ])->can('index', Playground\Matrix\Models\Ticket::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.matrix.api.tickets.create',
        'uses' => 'TicketController@create',
    ])->can('create', Playground\Matrix\Models\Ticket::class);

    Route::get('/edit/{ticket}', [
        'as' => 'playground.matrix.api.tickets.edit',
        'uses' => 'TicketController@edit',
    ])->whereUuid('ticket')
        ->can('edit', 'ticket');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.matrix.api.tickets.go',
    //     'uses' => 'TicketController@go',
    // ]);

    Route::get('/{ticket}', [
        'as' => 'playground.matrix.api.tickets.show',
        'uses' => 'TicketController@show',
    ])->whereUuid('ticket')
        ->can('detail', 'ticket');

    // Route::get('/{slug}', [
    //     'as'   => 'playground.matrix.api.tickets.slug',
    //     'uses' => 'TicketController@slug',
    // ])->where('slug', '[a-zA-Z0-9\-]+');

    // Route::post('/store', [
    //     'as'   => 'playground.matrix.api.tickets.store',
    //     'uses' => 'TicketController@store',
    // ])->can('store', \Playground\Matrix\Models\Ticket::class);

    // API

    Route::put('/lock/{ticket}', [
        'as' => 'playground.matrix.api.tickets.lock',
        'uses' => 'TicketController@lock',
    ])->whereUuid('ticket')
        ->can('lock', 'ticket');

    Route::delete('/lock/{ticket}', [
        'as' => 'playground.matrix.api.tickets.unlock',
        'uses' => 'TicketController@unlock',
    ])->whereUuid('ticket')
        ->can('unlock', 'ticket');

    Route::delete('/{ticket}', [
        'as' => 'playground.matrix.api.tickets.destroy',
        'uses' => 'TicketController@destroy',
    ])->whereUuid('ticket')
        ->can('delete', 'ticket')
        ->withTrashed();

    Route::put('/restore/{ticket}', [
        'as' => 'playground.matrix.api.tickets.restore',
        'uses' => 'TicketController@restore',
    ])->whereUuid('ticket')
        ->can('restore', 'ticket')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.tickets.post',
        'uses' => 'TicketController@store',
    ])->can('store', Playground\Matrix\Models\Ticket::class);

    // Route::put('/', [
    //     'as'   => 'playground.matrix.api.tickets.put',
    //     'uses' => 'TicketController@store',
    // ])->can('store', \Playground\Matrix\Models\Ticket::class);
    //
    // Route::put('/{ticket}', [
    //     'as'   => 'playground.matrix.api.tickets.put.id',
    //     'uses' => 'TicketController@store',
    // ])->whereUuid('ticket')->can('update', 'ticket');

    Route::patch('/{ticket}', [
        'as' => 'playground.matrix.api.tickets.patch',
        'uses' => 'TicketController@update',
    ])->whereUuid('ticket')->can('update', 'ticket');
});
