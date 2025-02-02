<?php

namespace Hyvor\Internal\Tests\Unit\InternalApi;

use Hyvor\Internal\Billing\License\Plan\BlogsPlan;
use Hyvor\Internal\Billing\License\Plan\CorePlan;
use Hyvor\Internal\Billing\License\Plan\TalkPlan;
use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(ComponentType::class)]
class ComponentTypeTest extends TestCase
{

    public function testName(): void
    {
        $this->assertEquals('HYVOR', ComponentType::CORE->name());
        $this->assertEquals('Hyvor Talk', ComponentType::TALK->name());
        $this->assertEquals('Hyvor Blogs', ComponentType::BLOGS->name());
    }

    public function testFromConfig(): void
    {
        config(['internal.component' => 'core']);
        $this->assertEquals(ComponentType::current(), ComponentType::CORE);

        config(['internal.component' => 'talk']);
        $this->assertEquals(ComponentType::current(), ComponentType::TALK);

        config(['internal.component' => 'blogs']);
        $this->assertEquals(ComponentType::current(), ComponentType::BLOGS);
    }

    public function testGetCoreUrl(): void
    {
        config(['internal.instance' => 'https://hyvor.com']);
        $this->assertEquals(ComponentType::CORE->getCoreUrl(), 'https://hyvor.com');

        config(['internal.instance' => 'https://talk.hyvor.com']);
        $this->assertEquals(ComponentType::TALK->getCoreUrl(), 'https://hyvor.com');

        // externl
        config(['internal.instance' => 'https://hyvor.mycompany.com']);
        $this->assertEquals(ComponentType::CORE->getCoreUrl(), 'https://hyvor.mycompany.com');

        // external product
        config(['internal.instance' => 'https://talk.hyvor.mycompany.com']);
        $this->assertEquals(ComponentType::TALK->getCoreUrl(), 'https://hyvor.mycompany.com');
    }

    public function testGetTheUrl(): void
    {
        // core
        $this->assertEquals(ComponentType::CORE->getUrlOf(ComponentType::TALK), 'https://talk.hyvor.com');
        $this->assertEquals(ComponentType::CORE->getUrlOf(ComponentType::CORE), 'https://hyvor.com');

        // product
        $this->assertEquals(ComponentType::TALK->getUrlOf(ComponentType::CORE), 'https://hyvor.com');
        $this->assertEquals(ComponentType::TALK->getUrlOf(ComponentType::BLOGS), 'https://blogs.hyvor.com');

        // other subdomain
        config(['internal.instance' => 'https://hyvor.mycompany.com']);
        $this->assertEquals(ComponentType::BLOGS->getUrlOf(ComponentType::CORE), 'https://hyvor.mycompany.com');
        $this->assertEquals(ComponentType::BLOGS->getUrlOf(ComponentType::TALK), 'https://talk.hyvor.mycompany.com');
    }

    public function testPlans(): void
    {
        $plans = [
            [ComponentType::CORE, CorePlan::class],
            [ComponentType::TALK, TalkPlan::class],
            [ComponentType::BLOGS, BlogsPlan::class],
        ];

        foreach ($plans as $plan) {
            $this->assertInstanceOf($plan[1], $plan[0]->plans());
        }
    }

}
