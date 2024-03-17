<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Matrix\Api\Http\Controllers\ProjectTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground\ProjectRouteTest
 */
class ProjectRouteTest extends ProjectTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_matrix = true;
}
