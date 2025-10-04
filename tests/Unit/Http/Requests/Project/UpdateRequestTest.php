<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Api\Http\Requests\Project;

use Playground\Matrix\Api\Http\Requests\Project\UpdateRequest;
use Tests\Unit\Playground\Matrix\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Http\Requests\Project\UpdateRequestTest
 */
class UpdateRequestTest extends RequestTestCase
{
    protected string $requestClass = UpdateRequest::class;
}
