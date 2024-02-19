<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground;

use Playground\Test\Feature\Http\Controllers\Resource;
use Tests\Feature\Playground\Matrix\Api\Http\Controllers\SprintTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground\SprintRouteTest
 */
class SprintRouteTest extends SprintTestCase
{
    use Resource\Playground\CreateJsonTrait;
    use Resource\Playground\DestroyJsonTrait;
    use Resource\Playground\EditJsonTrait;
    use Resource\Playground\IndexJsonTrait;
    use Resource\Playground\LockJsonTrait;
    use Resource\Playground\RestoreJsonTrait;
    use Resource\Playground\ShowJsonTrait;
    use Resource\Playground\UnlockJsonTrait;
    use TestTrait;

    protected bool $load_migrations_playground = true;

    protected bool $load_migrations_matrix = true;
}