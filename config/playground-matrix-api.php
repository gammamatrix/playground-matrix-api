<?php

/**
 * Playground
 */

declare(strict_types=1);
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Playground\Matrix\Api\Policies\BacklogPolicy;
use Playground\Matrix\Api\Policies\BoardPolicy;
use Playground\Matrix\Api\Policies\EpicPolicy;
use Playground\Matrix\Api\Policies\FlowPolicy;
use Playground\Matrix\Api\Policies\MatrixPolicy;
use Playground\Matrix\Api\Policies\MilestonePolicy;
use Playground\Matrix\Api\Policies\NotePolicy;
use Playground\Matrix\Api\Policies\ProjectPolicy;
use Playground\Matrix\Api\Policies\ReleasePolicy;
use Playground\Matrix\Api\Policies\RoadmapPolicy;
use Playground\Matrix\Api\Policies\SourcePolicy;
use Playground\Matrix\Api\Policies\SprintPolicy;
use Playground\Matrix\Api\Policies\TagPolicy;
use Playground\Matrix\Api\Policies\TeamPolicy;
use Playground\Matrix\Api\Policies\TicketPolicy;
use Playground\Matrix\Api\Policies\VersionPolicy;
use Playground\Matrix\Models\Backlog;
use Playground\Matrix\Models\Board;
use Playground\Matrix\Models\Epic;
use Playground\Matrix\Models\Flow;
use Playground\Matrix\Models\Matrix;
use Playground\Matrix\Models\Milestone;
use Playground\Matrix\Models\Note;
use Playground\Matrix\Models\Project;
use Playground\Matrix\Models\Release;
use Playground\Matrix\Models\Roadmap;
use Playground\Matrix\Models\Source;
use Playground\Matrix\Models\Sprint;
use Playground\Matrix\Models\Tag;
use Playground\Matrix\Models\Team;
use Playground\Matrix\Models\Ticket;
use Playground\Matrix\Models\Version;

/**
 * Playground: Matrix API Configuration and Environment Variables
 */
return [

    /*
    |--------------------------------------------------------------------------
    | About Information
    |--------------------------------------------------------------------------
    |
    | By default, information will be displayed about this package when using:
    |
    | `artisan about`
    |
    */

    'about' => (bool) env('PLAYGROUND_MATRIX_API_ABOUT', true),

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    |
    | By default, translations and views are loaded.
    |
    */

    'load' => [
        'policies' => (bool) env('PLAYGROUND_MATRIX_API_LOAD_POLICIES', true),
        'routes' => (bool) env('PLAYGROUND_MATRIX_API_LOAD_ROUTES', true),
        'translations' => (bool) env('PLAYGROUND_MATRIX_API_LOAD_TRANSLATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    |
    */

    'middleware' => [
        'default' => env('PLAYGROUND_MATRIX_API_MIDDLEWARE_DEFAULT', [
            'web',
            SubstituteBindings::class,
            'auth:sanctum',
            EnsureFrontendRequestsAreStateful::class,
        ]),
        'auth' => env('PLAYGROUND_MATRIX_API_MIDDLEWARE_AUTH', [
            'web',
            SubstituteBindings::class,
            'auth:sanctum',
            EnsureFrontendRequestsAreStateful::class,
        ]),
        'guest' => env('PLAYGROUND_MATRIX_API_MIDDLEWARE_GUEST', [
            'web',
            SubstituteBindings::class,
            EnsureFrontendRequestsAreStateful::class,
        ]),
    ],

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    |
    */

    'policies' => [
        Backlog::class => BacklogPolicy::class,
        Board::class => BoardPolicy::class,
        Epic::class => EpicPolicy::class,
        Flow::class => FlowPolicy::class,
        Matrix::class => MatrixPolicy::class,
        Milestone::class => MilestonePolicy::class,
        Note::class => NotePolicy::class,
        Project::class => ProjectPolicy::class,
        Release::class => ReleasePolicy::class,
        Roadmap::class => RoadmapPolicy::class,
        Source::class => SourcePolicy::class,
        Sprint::class => SprintPolicy::class,
        Tag::class => TagPolicy::class,
        Team::class => TeamPolicy::class,
        Ticket::class => TicketPolicy::class,
        Version::class => VersionPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    'routes' => [
        'backlogs' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_BACKLOGS', true),
        'boards' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_BOARDS', true),
        'epics' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_EPICS', true),
        'flows' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_FLOWS', true),
        'matrices' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_MATRICES', true),
        'milestones' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_MILESTONES', true),
        'notes' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_NOTES', true),
        'projects' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_PROJECTS', true),
        'releases' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_RELEASES', true),
        'roadmaps' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_ROADMAPS', true),
        'sources' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_SOURCES', true),
        'sprints' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_SPRINTS', true),
        'tags' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_TAGS', true),
        'teams' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_TEAMS', true),
        'tickets' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_TICKETS', true),
        'versions' => (bool) env('PLAYGROUND_MATRIX_API_ROUTES_VERSIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Abilities
    |--------------------------------------------------------------------------
    |
    |
    */

    'abilities' => [
        'admin' => [
            'playground-matrix-api:*',
        ],
        'manager' => [
            'playground-matrix-api:backlog:*',
            'playground-matrix-api:board:*',
            'playground-matrix-api:epic:*',
            'playground-matrix-api:flow:*',
            'playground-matrix-api:matrix:*',
            'playground-matrix-api:milestone:*',
            'playground-matrix-api:note:*',
            'playground-matrix-api:project:*',
            'playground-matrix-api:release:*',
            'playground-matrix-api:roadmap:*',
            'playground-matrix-api:source:*',
            'playground-matrix-api:sprint:*',
            'playground-matrix-api:tag:*',
            'playground-matrix-api:team:*',
            'playground-matrix-api:ticket:*',
            'playground-matrix-api:version:*',
        ],
        'user' => [
            'playground-matrix-api:backlog:view',
            'playground-matrix-api:backlog:viewAny',
            'playground-matrix-api:board:view',
            'playground-matrix-api:board:viewAny',
            'playground-matrix-api:epic:view',
            'playground-matrix-api:epic:viewAny',
            'playground-matrix-api:flow:view',
            'playground-matrix-api:flow:viewAny',
            'playground-matrix-api:matrix:view',
            'playground-matrix-api:matrix:viewAny',
            'playground-matrix-api:milestone:view',
            'playground-matrix-api:milestone:viewAny',
            'playground-matrix-api:note:view',
            'playground-matrix-api:note:viewAny',
            'playground-matrix-api:project:view',
            'playground-matrix-api:project:viewAny',
            'playground-matrix-api:release:view',
            'playground-matrix-api:release:viewAny',
            'playground-matrix-api:roadmap:view',
            'playground-matrix-api:roadmap:viewAny',
            'playground-matrix-api:source:view',
            'playground-matrix-api:source:viewAny',
            'playground-matrix-api:sprint:view',
            'playground-matrix-api:sprint:viewAny',
            'playground-matrix-api:tag:view',
            'playground-matrix-api:tag:viewAny',
            'playground-matrix-api:team:view',
            'playground-matrix-api:team:viewAny',
            'playground-matrix-api:ticket:view',
            'playground-matrix-api:ticket:viewAny',
            'playground-matrix-api:version:view',
            'playground-matrix-api:version:viewAny',
        ],
    ],
];
