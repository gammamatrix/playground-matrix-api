<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers;

use Playground\Matrix\Models\Backlog;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\BacklogTestCase
 */
class BacklogTestCase extends PlaygroundCase
{
    public string $fqdn = Backlog::class;

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
        'model_camel' => 'backlog',
        'model_camels' => 'backlogs',
        'model_kebab' => 'backlog',
        'model_kebabs' => 'backlogs',
        'model_lower' => 'backlog',
        'model_lowers' => 'backlogs',
        'model_label' => 'Backlog',
        'model_label_plural' => 'Backlogs',
        'model_labels' => 'Backlogs',
        'model_route' => 'playground.matrix.api.backlogs',
        'model_route_param' => 'backlog',
        'model_slug' => 'backlog',
        'model_slugs' => 'backlogs',
        'model_slug_plural' => 'backlogs',
        'model_snake' => 'backlog',
        'model_snakes' => 'backlogs',
        'model_studly' => 'Backlog',
        'model_studlies' => 'Backlogs',
        'model_variable' => 'backlog',
        'model_variables' => 'backlogs',
        'model_variable_plural' => 'backlogs',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_labels' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'module_slugs' => 'matrices',
        'privilege' => 'playground-matrix-api:backlog',
        'table' => 'matrix_backlogs',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'backlog_type',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'matrix_id',
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
        'team_id',
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
