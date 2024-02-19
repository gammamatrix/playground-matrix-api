<?php
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground;

use Playground\Test\Feature\Http\Controllers\Resource;
use Tests\Feature\Playground\Matrix\Api\Http\Controllers\BacklogTestCase;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground\BacklogRouteTest
 */
class BacklogRouteTest extends BacklogTestCase
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

    // public function test_dump_console_about(): void
    // {
    //     $result = $this->withoutMockingConsoleOutput()->artisan('about');
    //     dump(\Illuminate\Support\Facades\Artisan::output());
    // }

    // public function test_dump_console_route_list(): void
    // {
    //     $result = $this->withoutMockingConsoleOutput()->artisan('route:list -vvv');
    //     dump(\Illuminate\Support\Facades\Artisan::output());
    // }
}
