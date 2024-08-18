<?php
/**
 * Playground
 */

declare(strict_types=1);
namespace Tests\Unit\Playground\Matrix\Api\Policies\RoadmapPolicy;

use PHPUnit\Framework\Attributes\CoversClass;
use Playground\Matrix\Api\Policies\RoadmapPolicy;
use Tests\Unit\Playground\Matrix\Api\TestCase;

/**
 * \Tests\Unit\Playground\Matrix\Api\Policies\RoadmapPolicy\PolicyTest
 */
#[CoversClass(RoadmapPolicy::class)]
class PolicyTest extends TestCase
{
    public function test_policy_instance(): void
    {
        $instance = new RoadmapPolicy;

        $this->assertInstanceOf(RoadmapPolicy::class, $instance);
    }
}
