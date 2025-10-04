<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Api\Http\Requests\Flow;

use Playground\Matrix\Api\Http\Requests\Flow\UpdateRequest;
use Tests\Unit\Playground\Matrix\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Http\Requests\Flow\UpdateRequestTest
 */
class UpdateRequestTest extends RequestTestCase
{
    protected string $requestClass = UpdateRequest::class;
}
