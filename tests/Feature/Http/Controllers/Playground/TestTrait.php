<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers\Playground;

/**
 * \Tests\Unit\Playground\Matrix\Api\Playground\TestTrait
 */
trait TestTrait
{
    /**
     * Set up the environment.
     *
     * @param  \Illuminate\Foundation\Application  $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('auth.providers.users.model', '\\Playground\\Models\\Playground');
        $app['config']->set('auth.testing.password', 'password');
        $app['config']->set('auth.testing.hashed', false);

        $app['config']->set('playground-matrix.load.migrations', true);

        $app['config']->set('app.debug', false);
        $app['config']->set('playground-auth.debug', false);

        $app['config']->set('playground-auth.verify', 'roles');
        // $app['config']->set('playground-auth.verify', 'privileges');
        $app['config']->set('playground-auth.sanctum', false);
        $app['config']->set('playground-auth.hasPrivilege', true);
        $app['config']->set('playground-auth.userPrivileges', true);
        $app['config']->set('playground-auth.hasRole', true);
        $app['config']->set('playground-auth.userRole', true);
        $app['config']->set('playground-auth.userRoles', true);

        // $app['config']->set('playground-auth.token.roles', true);
        // $app['config']->set('playground-auth.token.sanctum', true);

        // $middleware = [];
        // api,auth:sanctum,web

        // $app['config']->set('playground-matrix-api.routes.matrix', true);
        // $app['config']->set('playground-matrix-api.routes.backlogs', true);
        // $app['config']->set('playground-matrix-api.routes.boards', true);
        // $app['config']->set('playground-matrix-api.routes.epics', true);
        // $app['config']->set('playground-matrix-api.routes.flows', true);
        // $app['config']->set('playground-matrix-api.routes.milestones', true);
        // $app['config']->set('playground-matrix-api.routes.notes', true);
        // $app['config']->set('playground-matrix-api.routes.projects', true);
        // $app['config']->set('playground-matrix-api.routes.releases', true);
        // $app['config']->set('playground-matrix-api.routes.roadmaps', true);
        // $app['config']->set('playground-matrix-api.routes.sources', true);
        // $app['config']->set('playground-matrix-api.routes.sprints', true);
        // $app['config']->set('playground-matrix-api.routes.tags', true);
        // $app['config']->set('playground-matrix-api.routes.teams', true);
        // $app['config']->set('playground-matrix-api.routes.tickets', true);
        // $app['config']->set('playground-matrix-api.routes.versions', true);

        // $app['config']->set('playground-matrix-api.sitemap.enable', true);
        // $app['config']->set('playground-matrix-api.sitemap.guest', true);
        // $app['config']->set('playground-matrix-api.sitemap.user', true);

    }
}
