<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Matrix\Api;

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
            ServiceProvider::class,
            PlaygroundAuthServiceProvider::class,
            PlaygroundHttpServiceProvider::class,
            PlaygroundMatrixServiceProvider::class,
            PlaygroundServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', '\\Playground\\Models\\Playground');
        $app['config']->set('playground-auth.verify', 'user');
        $app['config']->set('auth.testing.password', 'password');
        $app['config']->set('auth.testing.hashed', false);

        $app['config']->set('playground-matrix.load.migrations', true);
    }
}
