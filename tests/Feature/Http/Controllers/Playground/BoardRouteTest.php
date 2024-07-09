<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Matrix\Api\Http\Controllers\BoardTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground\BoardRouteTest
 */
class BoardRouteTest extends BoardTestCase
{
    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_matrix = true;
}
