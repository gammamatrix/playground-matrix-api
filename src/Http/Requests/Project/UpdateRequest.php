<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Matrix\Api\Http\Requests\Project;

use Playground\Http\Requests\UpdateRequest as BaseUpdateRequest;

/**
 * \Playground\Matrix\Api\Http\Requests\Project\UpdateRequest
 */
class UpdateRequest extends BaseUpdateRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'project_type' => ['nullable', 'string'],
        'owned_by_id' => ['nullable', 'uuid'],
        'parent_id' => ['nullable', 'uuid'],
        'backlog_id' => ['nullable', 'uuid'],
        'board_id' => ['nullable', 'uuid'],
        'epic_id' => ['nullable', 'uuid'],
        'flow_id' => ['nullable', 'uuid'],
        'matrix_id' => ['nullable', 'uuid'],
        'milestone_id' => ['nullable', 'uuid'],
        'note_id' => ['nullable', 'uuid'],
        'release_id' => ['nullable', 'uuid'],
        'roadmap_id' => ['nullable', 'uuid'],
        'source_id' => ['nullable', 'uuid'],
        'sprint_id' => ['nullable', 'uuid'],
        'tag_id' => ['nullable', 'uuid'],
        'team_id' => ['nullable', 'uuid'],
        'ticket_id' => ['nullable', 'uuid'],
        'version_id' => ['nullable', 'uuid'],
        'canceled_at' => ['nullable', 'string'],
        'closed_at' => ['nullable', 'string'],
        'embargo_at' => ['nullable', 'string'],
        'planned_end_at' => ['nullable', 'string'],
        'planned_start_at' => ['nullable', 'string'],
        'postponed_at' => ['nullable', 'string'],
        'published_at' => ['nullable', 'string'],
        'resolved_at' => ['nullable', 'string'],
        'resumed_at' => ['nullable', 'string'],
        'suspended_at' => ['nullable', 'string'],
        'timer_end_at' => ['nullable', 'string'],
        'timer_start_at' => ['nullable', 'string'],
        'gids' => ['integer'],
        'po' => ['integer'],
        'pg' => ['integer'],
        'pw' => ['integer'],
        'only_admin' => ['boolean'],
        'only_user' => ['boolean'],
        'only_guest' => ['boolean'],
        'allow_public' => ['boolean'],
        'status' => ['integer'],
        'rank' => ['integer'],
        'size' => ['integer'],
        'matrix' => ['nullable', 'array'],
        'x' => ['nullable', 'integer'],
        'y' => ['nullable', 'integer'],
        'z' => ['nullable', 'integer'],
        'r' => ['nullable', 'numeric'],
        'theta' => ['nullable', 'numeric'],
        'rho' => ['nullable', 'numeric'],
        'phi' => ['nullable', 'numeric'],
        'elevation' => ['nullable', 'numeric'],
        'latitude' => ['nullable', 'numeric'],
        'longitude' => ['nullable', 'numeric'],
        'active' => ['boolean'],
        'canceled' => ['boolean'],
        'closed' => ['boolean'],
        'completed' => ['boolean'],
        'cron' => ['boolean'],
        'duplicate' => ['boolean'],
        'featured' => ['boolean'],
        'fixed' => ['boolean'],
        'flagged' => ['boolean'],
        'internal' => ['boolean'],
        'locked' => ['boolean'],
        'pending' => ['boolean'],
        'planned' => ['boolean'],
        'prioritized' => ['boolean'],
        'problem' => ['boolean'],
        'published' => ['boolean'],
        'released' => ['boolean'],
        'resolved' => ['boolean'],
        'retired' => ['boolean'],
        'special' => ['boolean'],
        'suspended' => ['boolean'],
        'unknown' => ['boolean'],
        'locale' => ['string'],
        'label' => ['string'],
        'title' => ['string'],
        'byline' => ['string'],
        'slug' => ['nullable', 'string'],
        'url' => ['string'],
        'description' => ['string'],
        'introduction' => ['string'],
        'content' => ['nullable', 'string'],
        'summary' => ['nullable', 'string'],
        'key' => ['nullable', 'string'],
        'code_name' => ['nullable', 'string'],
        'icon' => ['string'],
        'image' => ['string'],
        'avatar' => ['string'],
        'ui' => ['nullable', 'array'],
        'assets' => ['nullable', 'array'],
        'backlog' => ['nullable', 'array'],
        'board' => ['nullable', 'array'],
        'flow' => ['nullable', 'array'],
        'history' => ['nullable', 'array'],
        'meta' => ['nullable', 'array'],
        'options' => ['nullable', 'array'],
        'roadmap' => ['nullable', 'array'],
        'sources' => ['nullable', 'array'],
        '_return_url' => ['nullable', 'url'],
    ];

    protected string $slug_table = 'matrix_projects';

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $input = [];

        $this->filterContentFields($input);
        $this->filterCommonFields($input);
        $this->filterStatus($input);
        $this->filterSystemFields($input);

        if (! empty($input)) {
            $this->merge($input);
        }
    }
}
