<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Matrix\Api\Http\Controllers\ReleaseTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground\ReleaseRouteTest
 */
class ReleaseRouteTest extends ReleaseTestCase
{
    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_matrix = true;
}
