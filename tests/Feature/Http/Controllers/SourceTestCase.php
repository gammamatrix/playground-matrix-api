<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Playground\Matrix\Models\Source;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\SourceTestCase
 */
class SourceTestCase extends PlaygroundCase
{
    /**
     * @var class-string<Model>
     */
    public string $fqdn = Source::class;

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
        'model_camel' => 'source',
        'model_camels' => 'sources',
        'model_kebab' => 'source',
        'model_kebabs' => 'sources',
        'model_lower' => 'source',
        'model_lowers' => 'sources',
        'model_label' => 'Source',
        'model_label_plural' => 'Sources',
        'model_labels' => 'Sources',
        'model_route' => 'playground.matrix.api.sources',
        'model_route_param' => 'source',
        'model_slug' => 'source',
        'model_slugs' => 'sources',
        'model_slug_plural' => 'sources',
        'model_snake' => 'source',
        'model_snakes' => 'sources',
        'model_studly' => 'Source',
        'model_studlies' => 'Sources',
        'model_variable' => 'source',
        'model_variables' => 'sources',
        'model_variable_plural' => 'sources',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_labels' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'module_slugs' => 'matrices',
        'privilege' => 'playground-matrix-api:source',
        'table' => 'matrix_sources',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'source_type',
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
