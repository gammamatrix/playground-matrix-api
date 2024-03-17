<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Playground\Matrix\Api\Http\Requests\Epic;

use Playground\Matrix\Api\Http\Requests\FormRequest;

/**
 * \Playground\Matrix\Api\Http\Requests\Epic\UnlockRequest
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
