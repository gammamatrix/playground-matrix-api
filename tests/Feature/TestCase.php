<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Carbon;
use Playground\Test\OrchestraTestCase;
use Tests\Unit\Playground\Matrix\Api\TestTrait;

/**
 * \Tests\Feature\Playground\Matrix\Api\TestCase
 */
class TestCase extends OrchestraTestCase
{
    use DatabaseTransactions;
    use TestTrait;

    protected bool $load_migrations_playground = false;

    protected bool $load_migrations_matrix = false;

    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Carbon::setTestNow(Carbon::now());

        if (! empty(env('TEST_DB_MIGRATIONS'))) {
            if ($this->load_migrations_playground) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-playground');
            }
            if ($this->load_migrations_matrix) {
                $this->loadMigrationsFrom(dirname(dirname(__DIR__)).'/database/migrations-matrix-uuid');
            }
        }
    }

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', 'Playground\\Test\\Models\\User');
        $app['config']->set('playground-auth.verify', 'user');
        $app['config']->set('auth.testing.password', 'password');
        $app['config']->set('auth.testing.hashed', false);

        $app['config']->set('playground-matrix.load.migrations', true);
    }
}
