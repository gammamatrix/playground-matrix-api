<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Requests\Board;

use Playground\Http\Requests\IndexRequest as BaseIndexRequest;

/**
 * \Playground\Matrix\Api\Http\Requests\Board\IndexRequest
 */
class IndexRequest extends BaseIndexRequest
{
    /**
     * @var array<string, mixed>
     */
    protected array $paginationDates = [
        'created_at' => ['column' => 'created_at', 'label' => 'Created At', 'nullable' => false],
        'updated_at' => ['column' => 'updated_at', 'label' => 'Updated At', 'nullable' => false],
        'deleted_at' => ['column' => 'deleted_at', 'label' => 'Deleted At', 'nullable' => true],
        'start_at' => ['column' => 'start_at', 'label' => 'Start At', 'nullable' => true],
        'planned_start_at' => ['column' => 'planned_start_at', 'label' => 'Planned Start At', 'nullable' => true],
        'end_at' => ['column' => 'end_at', 'label' => 'End At', 'nullable' => true],
        'planned_end_at' => ['column' => 'planned_end_at', 'label' => 'Planned End At', 'nullable' => true],
        'canceled_at' => ['column' => 'canceled_at', 'label' => 'Canceled At', 'nullable' => true],
        'closed_at' => ['column' => 'closed_at', 'label' => 'Closed At', 'nullable' => true],
        'embargo_at' => ['column' => 'embargo_at', 'label' => 'Embargo At', 'nullable' => true],
        'fixed_at' => ['column' => 'fixed_at', 'label' => 'Fixed At', 'nullable' => true],
        'postponed_at' => ['column' => 'postponed_at', 'label' => 'Postponed At', 'nullable' => true],
        'published_at' => ['column' => 'published_at', 'label' => 'Published At', 'nullable' => true],
        'released_at' => ['column' => 'released_at', 'label' => 'Released At', 'nullable' => true],
        'resumed_at' => ['column' => 'resumed_at', 'label' => 'Resumed At', 'nullable' => true],
        'resolved_at' => ['column' => 'resolved_at', 'label' => 'Resolved At', 'nullable' => true],
        'suspended_at' => ['column' => 'suspended_at', 'label' => 'Suspended At', 'nullable' => true],
    ];

    /**
     * @var array<string, mixed>
     */
    protected array $paginationFlags = [
        'active' => ['column' => 'active', 'label' => 'Active', 'icon' => 'fa-solid fa-person-running'],
        'canceled' => ['column' => 'canceled', 'label' => 'Canceled', 'icon' => 'fa-solid fa-ban text-warning'],
        'closed' => ['column' => 'closed', 'label' => 'Closed', 'icon' => 'fa-solid fa-xmark'],
        'completed' => ['column' => 'completed', 'label' => 'Completed', 'icon' => 'fa-solid fa-check'],
        'duplicate' => ['column' => 'duplicate', 'label' => 'Duplicate', 'icon' => 'fa-solid fa-clone'],
        'fixed' => ['column' => 'fixed', 'label' => 'Fixed', 'icon' => 'fa-solid fa-wrench'],
        'flagged' => ['column' => 'flagged', 'label' => 'Flagged', 'icon' => 'fa-solid fa-flag'],
        'internal' => ['column' => 'internal', 'label' => 'Internal', 'icon' => 'fa-solid fa-server'],
        'locked' => ['column' => 'locked', 'label' => 'Locked', 'icon' => 'fa-solid fa-lock text-warning'],
        'pending' => ['column' => 'pending', 'label' => 'Pending', 'icon' => 'fa-solid fa-circle-pause text-warning'],
        'planned' => ['column' => 'planned', 'label' => 'Planned', 'icon' => 'fa-solid fa-circle-pause text-success'],
        'problem' => ['column' => 'problem', 'label' => 'Problem', 'icon' => 'fa-solid fa-triangle-exclamation text-danger'],
        'published' => ['column' => 'published', 'label' => 'Published', 'icon' => 'fa-solid fa-book'],
        'released' => ['column' => 'released', 'label' => 'Released', 'icon' => 'fa-solid fa-dove'],
        'retired' => ['column' => 'retired', 'label' => 'Retired', 'icon' => 'fa-solid fa-chair text-success'],
        'resolved' => ['column' => 'resolved', 'label' => 'Resolved', 'icon' => 'fa-solid fa-check-double text-success'],
        'suspended' => ['column' => 'suspended', 'label' => 'Suspended', 'icon' => 'fa-solid fa-hand text-danger'],
        'unknown' => ['column' => 'unknown', 'label' => 'Unknown', 'icon' => 'fa-solid fa-question text-warning'],
        'only_admin' => ['column' => 'only_admin', 'label' => 'Only Admin', 'icon' => 'fa-solid fa-user-gear'],
        'only_user' => ['column' => 'only_user', 'label' => 'Only User', 'icon' => 'fa-solid fa-user'],
        'only_guest' => ['column' => 'only_guest', 'label' => 'Only Guest', 'icon' => 'fa-solid fa-person-rays'],
        'allow_public' => ['column' => 'allow_public', 'label' => 'Allow Public', 'icon' => 'fa-solid fa-users-line'],
    ];

    /**
     * @var array<string, mixed>
     */
    protected array $paginationIds = [
        'id' => ['column' => 'id', 'label' => 'Id', 'type' => 'uuid', 'nullable' => false],
        'owned_by_id' => ['column' => 'owned_by_id', 'label' => 'Owned By Id', 'type' => 'uuid', 'nullable' => false],
        'created_by_id' => ['column' => 'created_by_id', 'label' => 'Created By Id', 'type' => 'uuid', 'nullable' => false],
        'modified_by_id' => ['column' => 'modified_by_id', 'label' => 'Modified By Id', 'type' => 'uuid', 'nullable' => false],
        'parent_id' => ['column' => 'parent_id', 'label' => 'Parent Id', 'type' => 'uuid', 'nullable' => false],
        'board_type' => ['column' => 'board_type', 'label' => 'Board Type', 'type' => 'string', 'nullable' => true],
        'epic_id' => ['column' => 'epic_id', 'label' => 'Epic Id', 'type' => 'uuid', 'nullable' => false],
        'flow_id' => ['column' => 'flow_id', 'label' => 'Flow Id', 'type' => 'uuid', 'nullable' => false],
        'milestone_id' => ['column' => 'milestone_id', 'label' => 'Milestone Id', 'type' => 'uuid', 'nullable' => false],
        'note_id' => ['column' => 'note_id', 'label' => 'Note Id', 'type' => 'uuid', 'nullable' => false],
        'project_id' => ['column' => 'project_id', 'label' => 'Project Id', 'type' => 'uuid', 'nullable' => false],
        'release_id' => ['column' => 'release_id', 'label' => 'Release Id', 'type' => 'uuid', 'nullable' => false],
        'roadmap_id' => ['column' => 'roadmap_id', 'label' => 'Roadmap Id', 'type' => 'uuid', 'nullable' => false],
        'source_id' => ['column' => 'source_id', 'label' => 'Source Id', 'type' => 'uuid', 'nullable' => false],
        'sprint_id' => ['column' => 'sprint_id', 'label' => 'Sprint Id', 'type' => 'uuid', 'nullable' => false],
        'tag_id' => ['column' => 'tag_id', 'label' => 'Tag Id', 'type' => 'uuid', 'nullable' => false],
        'team_id' => ['column' => 'team_id', 'label' => 'Team Id', 'type' => 'uuid', 'nullable' => false],
        'ticket_id' => ['column' => 'ticket_id', 'label' => 'Ticket Id', 'type' => 'uuid', 'nullable' => false],
        'version_id' => ['column' => 'version_id', 'label' => 'Version Id', 'type' => 'uuid', 'nullable' => false],
    ];

    /**
     * @var array<string, mixed>
     */
    protected array $paginationColumns = [
        'label' => ['column' => 'label', 'label' => 'Label', 'type' => 'string', 'nullable' => false],
        'byline' => ['column' => 'byline', 'label' => 'Byline', 'type' => 'string', 'nullable' => false],
        'slug' => ['column' => 'slug', 'label' => 'Slug', 'type' => 'string', 'nullable' => false],
        'url' => ['column' => 'url', 'label' => 'Url', 'type' => 'string', 'nullable' => false],
        'description' => ['column' => 'description', 'label' => 'Description', 'type' => 'string', 'nullable' => false],
        'introduction' => ['column' => 'introduction', 'label' => 'Introduction', 'type' => 'string', 'nullable' => false],
        'content' => ['column' => 'content', 'label' => 'Content', 'type' => 'string', 'nullable' => false],
        'summary' => ['column' => 'summary', 'label' => 'Summary', 'type' => 'string', 'nullable' => false],
    ];
}
