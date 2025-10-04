<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Api\Policies\SprintPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Api\Policies\SprintPolicy;
use Tests\Unit\Playground\Matrix\Api\TestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Policies\SprintPolicy\PolicyTest
 */
#[CoversClass(SprintPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new SprintPolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(SprintPolicy::class, $instance);
    }
}
