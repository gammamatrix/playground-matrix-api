<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers;

use Playground\Matrix\Models\Note;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\NoteTestCase
 */
class NoteTestCase extends PlaygroundCase
{
    public string $fqdn = Note::class;

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
        'model_camel' => 'note',
        'model_camels' => 'notes',
        'model_kebab' => 'note',
        'model_kebabs' => 'notes',
        'model_lower' => 'note',
        'model_lowers' => 'notes',
        'model_label' => 'Note',
        'model_label_plural' => 'Notes',
        'model_labels' => 'Notes',
        'model_route' => 'playground.matrix.api.notes',
        'model_route_param' => 'note',
        'model_slug' => 'note',
        'model_slugs' => 'notes',
        'model_slug_plural' => 'notes',
        'model_snake' => 'note',
        'model_snakes' => 'notes',
        'model_studly' => 'Note',
        'model_studlies' => 'Notes',
        'model_variable' => 'note',
        'model_variables' => 'notes',
        'model_variable_plural' => 'notes',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_labels' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'module_slugs' => 'matrices',
        'privilege' => 'playground-matrix-api:note',
        'table' => 'matrix_notes',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'note_type',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'matrix_id',
        'created_at',
        'updated_at',
        'deleted_at',
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
