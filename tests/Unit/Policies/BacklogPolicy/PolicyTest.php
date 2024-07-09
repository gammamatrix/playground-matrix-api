<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Api\Policies\BacklogPolicy;

use Playground\Matrix\Api\Policies\BacklogPolicy;
use Tests\Unit\Playground\Matrix\Api\TestCase;

/**
 * \ests\Unit\Playground\Matrix\Api\Policies\BacklogPolicy\PolicyTest
 */
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new BacklogPolicy;

        $this->assertInstanceOf(BacklogPolicy::class, $instance);
    }
}
