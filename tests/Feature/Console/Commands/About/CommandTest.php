<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Api\Console\Commands\About;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Api\ServiceProvider;
use Tests\Feature\Playground\Matrix\Api\TestCase;

/**
 * \Tests\Feature\Playground\Matrix\Api\Console\Commands\About
 */
#[CoversClass(ServiceProvider::class)]
class CommandTest extends TestCase
{
    public function test_command_about_displays_package_information_and_succeed_with_code_0(): void
    {
        /**
         * @var \Illuminate\Testing\PendingCommand $result
         */
        $result = $this->artisan('about');
        $result->assertExitCode(0);
        $result->expectsOutputToContain('Playground: Matrix Api');
    }

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
