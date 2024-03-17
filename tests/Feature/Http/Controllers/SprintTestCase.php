<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Feature\Playground\Matrix\Api\Http\Controllers;

/**
 * \Tests\Feature\Playground\Matrix\Api\Http\Controllers\SprintTestCase
 */
class SprintTestCase extends TestCase
{
    public string $fqdn = \Playground\Matrix\Models\Sprint::class;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'model_attribute' => 'label',
        'model_label' => 'Sprint',
        'model_label_plural' => 'Sprints',
        'model_route' => 'playground.matrix.api.sprints',
        'model_slug' => 'sprint',
        'model_slug_plural' => 'sprints',
        'module_label' => 'Matrix',
        'module_label_plural' => 'Matrices',
        'module_route' => 'playground.matrix.api',
        'module_slug' => 'matrix',
        'privilege' => 'playground-matrix-api:sprint',
        'table' => 'matrix_sprints',
        'view' => 'playground-matrix-api::sprint',
    ];

    /**
     * @var array<int, string>
     */
    protected $structure_model = [
        'id',
        'created_by_id',
        'modified_by_id',
        'owned_by_id',
        'parent_id',
        'sprint_type',
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
        'tag_id',
        'team_id',
        'ticket_id',
        'version_id',
        'created_at',
        'deleted_at',
        'updated_at',
        'start_at',
        'planned_start_at',
        'end_at',
        'planned_end_at',
        'canceled_at',
        'closed_at',
        'embargo_at',
        'fixed_at',
        'postponed_at',
        'published_at',
        'released_at',
        'resumed_at',
        'resolved_at',
        'suspended_at',
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
        'active',
        'canceled',
        'closed',
        'completed',
        'duplicate',
        'fixed',
        'flagged',
        'internal',
        'locked',
        'pending',
        'planned',
        'problem',
        'published',
        'released',
        'retired',
        'resolved',
        'suspended',
        'unknown',
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
        'meta',
        'options',
        'roadmap',
        'sources',
    ];
}
