<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Requests\Epic;

use Playground\Http\Requests\StoreRequest as BaseStoreRequest;

/**
 * \Playground\Matrix\Api\Http\Requests\Epic\StoreRequest
 */
class StoreRequest extends BaseStoreRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'owned_by_id' => ['nullable', 'uuid'],
        'parent_id' => ['nullable', 'uuid'],
        'epic_type' => ['nullable', 'string'],
        'board_id' => ['nullable', 'uuid'],
        'flow_id' => ['nullable', 'uuid'],
        'milestone_id' => ['nullable', 'uuid'],
        'note_id' => ['nullable', 'uuid'],
        'project_id' => ['nullable', 'uuid'],
        'release_id' => ['nullable', 'uuid'],
        'roadmap_id' => ['nullable', 'uuid'],
        'source_id' => ['nullable', 'uuid'],
        'sprint_id' => ['nullable', 'uuid'],
        'tag_id' => ['nullable', 'uuid'],
        'team_id' => ['nullable', 'uuid'],
        'ticket_id' => ['nullable', 'uuid'],
        'version_id' => ['nullable', 'uuid'],
        'gids' => ['integer'],
        'po' => ['integer'],
        'pg' => ['integer'],
        'pw' => ['integer'],
        'status' => ['integer'],
        'rank' => ['integer'],
        'size' => ['integer'],
        'label' => ['string'],
        'byline' => ['string'],
        'slug' => ['nullable', 'string'],
        'content' => ['nullable', 'string'],
        'description' => ['string'],
        'introduction' => ['string'],
        'summary' => ['nullable', 'string'],
        'url' => ['string'],
        'active' => ['boolean'],
        'flagged' => ['boolean'],
        'internal' => ['boolean'],
        'locked' => ['boolean'],
        'pending' => ['boolean'],
        'planned' => ['boolean'],
        'problem' => ['boolean'],
        'published' => ['boolean'],
        'retired' => ['boolean'],
        'suspended' => ['boolean'],
        'unknown' => ['boolean'],
        'only_admin' => ['boolean'],
        'only_user' => ['boolean'],
        'only_guest' => ['boolean'],
        'allow_public' => ['boolean'],
        'ui' => ['nullable', 'array'],
        'icon' => ['string'],
        'image' => ['string'],
        'avatar' => ['string'],
        'start_at' => ['nullable', 'string'],
        'planned_start_at' => ['nullable', 'string'],
        'end_at' => ['nullable', 'string'],
        'planned_end_at' => ['nullable', 'string'],
        'canceled_at' => ['nullable', 'string'],
        'closed_at' => ['nullable', 'string'],
        'embargo_at' => ['nullable', 'string'],
        'fixed_at' => ['nullable', 'string'],
        'postponed_at' => ['nullable', 'string'],
        'published_at' => ['nullable', 'string'],
        'released_at' => ['nullable', 'string'],
        'resolved_at' => ['nullable', 'string'],
        'resumed_at' => ['nullable', 'string'],
        'suspended_at' => ['nullable', 'string'],
        'assets' => ['nullable', 'array'],
        'backlog' => ['nullable', 'string'],
        'board' => ['nullable', 'string'],
        'flow' => ['nullable', 'string'],
        'meta' => ['nullable', 'array'],
        'notes' => ['nullable', 'array'],
        'options' => ['nullable', 'array'],
        'roadmap' => ['nullable', 'array'],
        'sources' => ['nullable', 'array'],
        '_return_url' => ['nullable', 'url'],
    ];

    protected string $slug_table = 'matrix_epics';

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        parent::prepareForValidation();

        $input = [];

        if ($this->filled('content')) {
            $input['content'] = $this->purify($this->input('content'));
        }

        if ($this->filled('summary')) {
            $input['summary'] = $this->purify($this->input('summary'));
        }

        if ($this->filled('description')) {
            $input['description'] = $this->exorcise($this->input('description'));
        } elseif ($this->has('description')) {
            $input['description'] = '';
        }

        if ($this->filled('introduction')) {
            $input['introduction'] = $this->exorcise($this->input('introduction'));
        } elseif ($this->has('introduction')) {
            $input['introduction'] = '';
        }

        if (! empty($input)) {
            $this->merge($input);
        }
    }

    //    /**
    //      * Handle a passed validation attempt.
    //      *
    //      * @return void
    //      */
    //     protected function passedValidation()
    //     {
    //
    //     }
}
