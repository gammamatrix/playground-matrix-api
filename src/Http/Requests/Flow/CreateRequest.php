<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Requests\Flow;

use Playground\Matrix\Api\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Api\Http\Requests\Flow\CreateRequest
 */
class CreateRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        'owned_by_id' => ['nullable', 'uuid'],
        'parent_id' => ['nullable', 'uuid'],
        'flow_type' => ['nullable', 'string'],
        'note_id' => ['nullable', 'uuid'],
        'tag_id' => ['nullable', 'uuid'],
        'team_id' => ['nullable', 'uuid'],
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
        'postponed_at' => ['nullable', 'string'],
        'published_at' => ['nullable', 'string'],
        'released_at' => ['nullable', 'string'],
        'resumed_at' => ['nullable', 'string'],
        'suspended_at' => ['nullable', 'string'],
        'assets' => ['nullable', 'array'],
        'flow' => ['nullable', 'string'],
        'meta' => ['nullable', 'array'],
        'notes' => ['nullable', 'array'],
        'options' => ['nullable', 'array'],
        '_return_url' => ['nullable', 'url'],
    ];
}
