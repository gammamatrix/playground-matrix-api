<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Matrix\Api\Http\Requests\Tagged;

use Playground\Http\Requests\StoreRequest as BaseStoreRequest;

/**
 * \Playground\Matrix\Api\Http\Requests\Tagged\StoreRequest
 */
class StoreRequest extends BaseStoreRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'tag_id' => ['uuid', 'required'],
        'matrix_id' => ['nullable', 'uuid'],
        'backlog_id' => ['nullable', 'uuid'],
        'board_id' => ['nullable', 'uuid'],
        'epic_id' => ['nullable', 'uuid'],
        'flow_id' => ['nullable', 'uuid'],
        'milestone_id' => ['nullable', 'uuid'],
        'note_id' => ['nullable', 'uuid'],
        'project_id' => ['nullable', 'uuid'],
        'release_id' => ['nullable', 'uuid'],
        'roadmap_id' => ['nullable', 'uuid'],
        'source_id' => ['nullable', 'uuid'],
        'sprint_id' => ['nullable', 'uuid'],
        'team_id' => ['nullable', 'uuid'],
        'ticket_id' => ['nullable', 'uuid'],
        'version_id' => ['nullable', 'uuid'],
        '_return_url' => ['nullable', 'url'],
    ];

    protected string $slug_table = 'matrix_tagged';

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
