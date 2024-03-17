<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Matrix\Api\Http\Controllers\NoteTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground\NoteRouteTest
 */
class NoteRouteTest extends NoteTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_matrix = true;
}
