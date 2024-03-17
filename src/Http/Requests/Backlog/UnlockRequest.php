<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Requests\Backlog;

use Playground\Matrix\Api\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Api\Http\Requests\Backlog\UnlockRequest
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
