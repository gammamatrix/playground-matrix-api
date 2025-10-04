<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Api\Http\Requests\Epic;

use Tests\Unit\Playground\Matrix\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Http\Requests\Epic\LockRequestTest
 */
class LockRequestTest extends RequestTestCase
{
    protected string $requestClass = \Playground\Matrix\Api\Http\Requests\Epic\LockRequest::class;
}
