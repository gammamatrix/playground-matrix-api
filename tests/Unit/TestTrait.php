<?php
/**
 * Playground
 *
 */

namespace Tests\Unit\Playground\Matrix\Api;

use Playground\ServiceProvider as PlaygroundServiceProvider;
use Playground\Auth\ServiceProvider as PlaygroundAuthServiceProvider;
use Playground\Http\ServiceProvider as PlaygroundHttpServiceProvider;
use Playground\Matrix\ServiceProvider as PlaygroundMatrixServiceProvider;
use Playground\Matrix\Api\ServiceProvider;

/**
 * \Tests\Unit\Playground\Matrix\Api\TestTrait
 *
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
        ];
    }
}
