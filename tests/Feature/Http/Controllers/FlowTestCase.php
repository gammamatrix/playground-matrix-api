<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers;

use Playground\Matrix\Models\Flow;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\FlowTestCase
 */
class FlowTestCase extends PlaygroundCase
{
    public string $fqdn = Flow::class;

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
        'model_camel' => 'flow',
        'model_camels' => 'flows',
        'model_kebab' => 'flow',
        'model_kebabs' => 'flows',
        'model_lower' => 'flow',
        'model_lowers' => 'flows',
        'model_label' => 'Flow',
        'model_label_plural' => 'Flows',
        'model_labels' => 'Flows',
        'model_route' => 'playground.matrix.api.flows',
        'model_route_param' => 'flow',
        'model_slug' => 'flow',
        'model_slugs' => 'flows',
        'model_slug_plural' => 'flows',
        'model_snake' => 'flow',
        'model_snakes' => 'flows',
        'model_studly' => 'Flow',
        'model_studlies' => 'Flows',
        'model_variable' => 'flow',
        'model_variables' => 'flows',
        'model_variable_plural' => 'flows',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_labels' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'module_slugs' => 'matrices',
        'privilege' => 'playground-matrix-api:flow',
        'table' => 'matrix_flows',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'flow_type',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'matrix_id',
        'note_id',
        'team_id',
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
        'meta',
        'notes',
        'options',
        'sources',
    ];
}
