<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground;

use Tests\Feature\Playground\Matrix\Api\Http\Controllers\TicketTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground\TicketRouteTest
 */
class TicketRouteTest extends TicketTestCase
{
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_matrix = true;
}
