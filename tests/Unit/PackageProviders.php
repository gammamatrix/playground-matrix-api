<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Api;

/**
 * \Tests\Unit\Playground\Matrix\Api\PackageProviders
 */
trait PackageProviders
{
    protected function getPackageProviders($app)
    {
        return [
            \Playground\ServiceProvider::class,
            \Playground\Auth\ServiceProvider::class,
            \Playground\Http\ServiceProvider::class,
            \Playground\Matrix\ServiceProvider::class,
            \Playground\Matrix\Api\ServiceProvider::class,
            \Laravel\Sanctum\SanctumServiceProvider::class,
        ];
    }
}
