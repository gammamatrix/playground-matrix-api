<?php
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Requests\Milestone;

use Playground\Matrix\Api\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Api\Http\Requests\Milestone\UnlockRequest
 */
class UnlockRequest extends FormRequest
{
    /**
     * @var array<string, string|array<mixed>>
     */
    public const RULES = [
        '_return_url' => ['nullable', 'url'],
    ];
}