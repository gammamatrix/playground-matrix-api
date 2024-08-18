<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Api\Http\Requests\Matrix;

use Playground\Matrix\Api\Http\Requests\Matrix\UpdateRequest;
use Tests\Unit\Playground\Matrix\Api\Http\Requests\RequestTestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Http\Requests\Matrix\UpdateRequestTest
 */
class UpdateRequestTest extends RequestTestCase
{
    protected string $requestClass = UpdateRequest::class;

    public function test_UpdateRequest_rules_with_optional_revisions_disabled(): void
    {
        config(['playground-matrix-api.revisions.optional' => false]);
        $instance = new UpdateRequest;
        $rules = $instance->rules();
        $this->assertNotEmpty($rules);
        $this->assertIsArray($rules);
        $this->assertArrayNotHasKey('revision', $rules);
    }

    public function test_UpdateRequest_rules_with_optional_revisions_enabled(): void
    {
        config(['playground-matrix-api.revisions.optional' => true]);
        $instance = new UpdateRequest;
        $rules = $instance->rules();
        $this->assertNotEmpty($rules);
        $this->assertIsArray($rules);
        $this->assertArrayHasKey('revision', $rules);
        $this->assertSame('bool', $rules['revision']);
    }
}
