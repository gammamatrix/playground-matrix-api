<?php

declare(strict_types=1);
/**
 * Playground
 */
namespace Tests\Unit\Playground\Matrix\Api\Http\Requests\Backlog;

use Playground\Matrix\Api\Http\Requests\Backlog\StoreRequest;
use Tests\Unit\Playground\Matrix\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Http\Requests\Backlog\StoreRequestTest
 */
class StoreRequestTest extends RequestTestCase
{
    protected string $requestClass = StoreRequest::class;
}
