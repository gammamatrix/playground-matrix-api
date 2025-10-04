<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Unit\Playground\Matrix\Api\Policies\MatrixPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Api\Policies\MatrixPolicy;
use Tests\Unit\Playground\Matrix\Api\TestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Policies\MatrixPolicy\PolicyTest
 */
#[CoversClass(MatrixPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new MatrixPolicy;

        /** @phpstan-ignore method.alreadyNarrowedType */
        $this->assertInstanceOf(MatrixPolicy::class, $instance);
    }
}
