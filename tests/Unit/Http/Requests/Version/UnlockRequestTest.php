<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Api\Http\Requests\Version;

use Tests\Unit\Playground\Matrix\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Http\Requests\Version\UnlockRequestTest
 */
class UnlockRequestTest extends RequestTestCase
{
    protected string $requestClass = \Playground\Matrix\Api\Http\Requests\Version\UnlockRequest::class;
}
