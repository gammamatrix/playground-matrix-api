<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Matrix\Api;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Playground\Auth\Policies\Policy;

/**
 * \Playground\Matrix\Api\ServiceProvider
 */
class ServiceProvider extends AuthServiceProvider
{
    public const string VERSION = '74.0.0';

    public string $package = 'playground-matrix-api';

    /**
     * Bootstrap any package services.
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /**
         * @var array{
         *        about: bool,
         *        layout: string,
         *        load: array{
         *            policies: bool,
         *            routes: bool,
         *            translations: bool
         *        },
         *        middleware: array{
         *            default: string|string[],
         *            auth: string|string[],
         *            guest: string|string[]
         *        },
         *        policies: array<
         *            class-string<Model>,
         *            class-string<Policy>
         *        >,
         *        routes: array{
         *             backlogs: bool,
         *             boards: bool,
         *             epics: bool,
         *             flows: bool,
         *             matrices: bool,
         *             milestones: bool,
         *             notes: bool,
         *             projects: bool,
         *             releases: bool,
         *             roadmaps: bool,
         *             sources: bool,
         *             sprints: bool,
         *             tags: bool,
         *             teams: bool,
         *             tickets: bool,
         *             versions: bool,
         *        },
         *        abilities: array<string, string[]>,
         *    } $config
         */
        $config = config($this->package);

        if (! empty($config['load']) && is_array($config['load'])) {

            if (! empty($config['load']['translations'])) {
                $this->loadTranslationsFrom(
                    dirname(__DIR__).'/lang',
                    $this->package
                );
            }

            if (! empty($config['load']['policies'])
                && ! empty($config['policies'])
                && is_array($config['policies'])
            ) {
                $this->setPolicies($config['policies']);
                $this->registerPolicies();
            }

            if (! empty($config['load']['routes'])
                && ! empty($config['routes'])
                && is_array($config['routes'])
            ) {
                $this->routes($config['routes']);
            }
        }

        if (App::runningInConsole()) {
            // Publish configuration
            $this->publishes([
                sprintf('%1$s/config/%2$s.php', dirname(__DIR__), $this->package) => config_path(sprintf('%1$s.php', $this->package)),
            ], 'playground-config');

            // Publish routes
            $this->publishes([
                dirname(__DIR__).'/routes' => base_path('routes/playground-matrix-api'),
            ], 'playground-routes');
        }

        if (! empty($config['about'])) {
            $this->about();
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/config/playground-matrix-api.php',
            $this->package
        );
    }

    /**
     * Set the application's policies from the configuration.
     *
     * @param  array<class-string, class-string>  $policies
     */
    public function setPolicies(array $policies): void
    {
        foreach ($policies as $model => $policy) {
            if (! is_string($model) || ! class_exists($model)) {
                Log::error('Expecting the model to exist for the policy.', [
                    '__METHOD__' => __METHOD__,
                    'model' => is_string($model) ? $model : gettype($model),
                    'policy' => is_string($policy) ? $policy : gettype($policy),
                    'policies' => $policies,
                ]);

                continue;
            }
            if (! is_string($policy) || ! class_exists($policy)) {
                Log::error('Expecting the policy to exist for the model.', [
                    '__METHOD__' => __METHOD__,
                    'model' => $model,
                    'policy' => is_string($policy) ? $policy : gettype($policy),
                    'policies' => $policies,
                ]);

                continue;
            }
            $this->policies[$model] = $policy;
        }
    }

    /**
     * @param  array<string, mixed>  $config
     */
    public function routes(array $config): void
    {
        if (! empty($config['backlogs'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/backlogs.php');
        }
        if (! empty($config['boards'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/boards.php');
        }
        if (! empty($config['epics'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/epics.php');
        }
        if (! empty($config['flows'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/flows.php');
        }
        if (! empty($config['matrices'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/matrices.php');
        }
        if (! empty($config['milestones'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/milestones.php');
        }
        if (! empty($config['notes'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/notes.php');
        }
        if (! empty($config['projects'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/projects.php');
        }
        if (! empty($config['releases'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/releases.php');
        }
        if (! empty($config['roadmaps'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/roadmaps.php');
        }
        if (! empty($config['sources'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/sources.php');
        }
        if (! empty($config['sprints'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/sprints.php');
        }
        if (! empty($config['tags'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/tags.php');
        }
        if (! empty($config['teams'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/teams.php');
        }
        if (! empty($config['tickets'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/tickets.php');
        }
        if (! empty($config['versions'])) {
            $this->loadRoutesFrom(dirname(__DIR__).'/routes/versions.php');
        }
    }

    public function about(): void
    {
        $config = config($this->package);
        $config = is_array($config) ? $config : [];

        $load = ! empty($config['load']) && is_array($config['load']) ? $config['load'] : [];

        $middleware = ! empty($config['middleware']) && is_array($config['middleware']) ? $config['middleware'] : [];

        $routes = ! empty($config['routes']) && is_array($config['routes']) ? $config['routes'] : [];

        $sitemap = ! empty($config['sitemap']) && is_array($config['sitemap']) ? $config['sitemap'] : [];

        AboutCommand::add('Playground: Matrix API', fn () => [

            '<fg=yellow;options=bold>Load</> Policies' => ! empty($load['policies']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=yellow;options=bold>Load</> Routes' => ! empty($load['routes']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=yellow;options=bold>Load</> Translations' => ! empty($load['translations']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',

            '<fg=yellow;options=bold>Middleware</> auth' => ! empty($middleware['auth']) ? sprintf('%s', json_encode($middleware['auth'])) : '',
            '<fg=yellow;options=bold>Middleware</> default' => ! empty($middleware['default']) ? sprintf('%s', json_encode($middleware['default'])) : '',
            '<fg=yellow;options=bold>Middleware</> guest' => ! empty($middleware['guest']) ? sprintf('%s', json_encode($middleware['guest'])) : '',

            '<fg=red;options=bold>Route</> backlogs' => ! empty($routes['backlogs']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> boards' => ! empty($routes['boards']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> epics' => ! empty($routes['epics']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> flows' => ! empty($routes['flows']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> matrices' => ! empty($routes['matrices']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> milestones' => ! empty($routes['milestones']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> notes' => ! empty($routes['notes']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> projects' => ! empty($routes['projects']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> releases' => ! empty($routes['releases']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> roadmaps' => ! empty($routes['roadmaps']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> sources' => ! empty($routes['sources']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> sprints' => ! empty($routes['sprints']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> tags' => ! empty($routes['tags']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> teams' => ! empty($routes['teams']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> tickets' => ! empty($routes['tickets']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',
            '<fg=red;options=bold>Route</> versions' => ! empty($routes['versions']) ? '<fg=green;options=bold>ENABLED</>' : '<fg=yellow;options=bold>DISABLED</>',

            'Package' => $this->package,
            'Version' => ServiceProvider::VERSION,
        ]);
    }
}
