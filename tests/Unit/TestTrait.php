<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Matrix\Api;

use Laravel\Sanctum\SanctumServiceProvider;
use Playground\Auth\ServiceProvider as PlaygroundAuthServiceProvider;
use Playground\Http\ServiceProvider as PlaygroundHttpServiceProvider;
use Playground\Matrix\Api\ServiceProvider;
use Playground\Matrix\ServiceProvider as PlaygroundMatrixServiceProvider;
use Playground\ServiceProvider as PlaygroundServiceProvider;

/**
 * \Tests\Unit\Playground\Matrix\Api\TestTrait
 */
trait TestTrait
{
    protected function getPackageProviders($app)
    {
        return [
            PlaygroundAuthServiceProvider::class,
            PlaygroundHttpServiceProvider::class,
            PlaygroundMatrixServiceProvider::class,
            PlaygroundServiceProvider::class,
            ServiceProvider::class,
            SanctumServiceProvider::class,
        ];
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
