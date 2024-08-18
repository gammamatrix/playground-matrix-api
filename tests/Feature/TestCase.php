<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Feature\Playground\Matrix\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Playground\Test\OrchestraTestCase;
use Tests\Unit\Playground\Matrix\Api\PackageProviders;

/**
 * \Tests\Feature\Playground\Matrix\Api\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use DatabaseTransactions;
    use PackageProviders;

    /**
     * @var array<string, array<string, array<int, string>>>
     */
    protected array $load_migrations = [
        'gammamatrix' => [
            'playground-matrix' => [
                // 'migrations',
            ],
        ],
    ];

    protected bool $hasMigrations = true;

    protected bool $load_migrations_laravel = false;

    protected bool $load_migrations_package = false;

    protected bool $load_migrations_playground = true;

    protected bool $setUpUserForPlayground = false;
}
