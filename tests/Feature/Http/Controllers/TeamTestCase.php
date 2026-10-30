<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers;

use Playground\Matrix\Models\Team;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\TeamTestCase
 */
class TeamTestCase extends PlaygroundCase
{
    public string $fqdn = Team::class;

    protected int $status_code_json_guest_create = 401;

    protected int $status_code_json_guest_destroy = 401;

    protected int $status_code_json_guest_edit = 401;

    protected int $status_code_json_guest_index = 401;

    protected int $status_code_json_guest_lock = 401;

    protected int $status_code_json_guest_restore = 401;

    protected int $status_code_json_guest_show = 401;

    protected int $status_code_guest_json_store = 401;

    protected int $status_code_guest_json_unlock = 401;

    protected int $status_code_guest_json_update = 401;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'title',
        'model_camel' => 'team',
        'model_camels' => 'teams',
        'model_kebab' => 'team',
        'model_kebabs' => 'teams',
        'model_lower' => 'team',
        'model_lowers' => 'teams',
        'model_label' => 'Team',
        'model_label_plural' => 'Teams',
        'model_labels' => 'Teams',
        'model_route' => 'playground.matrix.api.teams',
        'model_route_param' => 'team',
        'model_slug' => 'team',
        'model_slugs' => 'teams',
        'model_slug_plural' => 'teams',
        'model_snake' => 'team',
        'model_snakes' => 'teams',
        'model_studly' => 'Team',
        'model_studlies' => 'Teams',
        'model_variable' => 'team',
        'model_variables' => 'teams',
        'model_variable_plural' => 'teams',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_labels' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'module_slugs' => 'matrices',
        'privilege' => 'playground-matrix-api:team',
        'table' => 'matrix_teams',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'team_type',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'matrix_id',
        'backlog_id',
        'board_id',
        'epic_id',
        'flow_id',
        'milestone_id',
        'note_id',
        'project_id',
        'release_id',
        'roadmap_id',
        'source_id',
        'sprint_id',
        'ticket_id',
        'version_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'canceled_at',
        'closed_at',
        'embargo_at',
        'planned_end_at',
        'planned_start_at',
        'postponed_at',
        'published_at',
        'resolved_at',
        'resumed_at',
        'suspended_at',
        'timer_end_at',
        'timer_start_at',
        'gids',
        'po',
        'pg',
        'pw',
        'only_admin',
        'only_user',
        'only_guest',
        'allow_public',
        'status',
        'rank',
        'size',
        'matrix',
        'x',
        'y',
        'z',
        'r',
        'theta',
        'rho',
        'phi',
        'elevation',
        'latitude',
        'longitude',
        'active',
        'canceled',
        'closed',
        'completed',
        'cron',
        'featured',
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'prioritized',
        'problem',
        'published',
        'released',
        'retired',
        'special',
        'suspended',
        'unknown',
        'locale',
        'label',
        'title',
        'byline',
        'slug',
        'url',
        'description',
        'introduction',
        'content',
        'summary',
        'icon',
        'image',
        'avatar',
        'ui',
        'assets',
        'backlog',
        'board',
        'flow',
        'history',
        'meta',
        'notes',
        'options',
        'roadmap',
        'sources',
    ];
}
