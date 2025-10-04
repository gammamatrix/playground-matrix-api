<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Api\Http\Requests\Flow;

use Tests\Unit\Playground\Matrix\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Http\Requests\Flow\ShowRequestTest
 */
class ShowRequestTest extends RequestTestCase
{
    protected string $requestClass = \Playground\Matrix\Api\Http\Requests\Flow\ShowRequest::class;
}
