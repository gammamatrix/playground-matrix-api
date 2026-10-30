<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Matrix\Models\Tagged;

/*
|--------------------------------------------------------------------------
| Matrix API Routes: Tagged
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/matrix/tagged',
    'middleware' => config('playground-matrix-api.middleware.default'),
    'namespace' => '\Playground\Matrix\Api\Http\Controllers',
], function () {

    // API

    Route::delete('/{tagged}', [
        'as' => 'playground.matrix.api.tagged.destroy',
        'uses' => 'TaggedController@destroy',
    ])->whereUuid('tagged')->can('delete', 'tagged')->withTrashed();

    Route::post('/', [
        'as' => 'playground.matrix.api.tagged.post',
        'uses' => 'TaggedController@store',
    ])->can('store', Tagged::class);
});
