<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Playground\Matrix\Models\Ticket;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\TicketTestCase
 */
class TicketTestCase extends PlaygroundCase
{
    /**
     * @var class-string<Model>
     */
    public string $fqdn = Ticket::class;

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
        'model_camel' => 'ticket',
        'model_camels' => 'tickets',
        'model_kebab' => 'ticket',
        'model_kebabs' => 'tickets',
        'model_lower' => 'ticket',
        'model_lowers' => 'tickets',
        'model_label' => 'Ticket',
        'model_label_plural' => 'Tickets',
        'model_labels' => 'Tickets',
        'model_route' => 'playground.matrix.api.tickets',
        'model_route_param' => 'ticket',
        'model_slug' => 'ticket',
        'model_slugs' => 'tickets',
        'model_slug_plural' => 'tickets',
        'model_snake' => 'ticket',
        'model_snakes' => 'tickets',
        'model_studly' => 'Ticket',
        'model_studlies' => 'Tickets',
        'model_variable' => 'ticket',
        'model_variables' => 'tickets',
        'model_variable_plural' => 'tickets',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_labels' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'module_slugs' => 'matrices',
        'privilege' => 'playground-matrix-api:ticket',
        'table' => 'matrix_tickets',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'ticket_type',
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
        'team_id',
        'version_id',
        'completed_by_id',
        'duplicate_id',
        'fixed_by_id',
        'reported_by_id',
        'version_fixed_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'canceled_at',
        'closed_at',
        'embargo_at',
        'fixed_at',
        'planned_end_at',
        'planned_start_at',
        'postponed_at',
        'published_at',
        'released_at',
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
        'duplicate',
        'featured',
        'fixed',
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'prioritized',
        'problem',
        'published',
        'released',
        'resolved',
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
        'handler',
        'key',
        'code',
        'key_code_hash',
        'priority',
        'severity',
        'resolution',
        'step',
        'state',
        'workflow_type',
        'points',
        'actual',
        'expected',
        'story',
        'steps',
        'criteria',
        'reproducibility',
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
