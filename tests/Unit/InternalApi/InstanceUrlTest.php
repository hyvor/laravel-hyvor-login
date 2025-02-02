<?php

namespace Hyvor\Internal\Tests\Unit\InternalApi;

use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalApi\InstanceUrl;
use Hyvor\Internal\Tests\TestCase;
use PHPUnit\Framework\Attributes\CoversClass;

#[CoversClass(InstanceUrl::class)]
class InstanceUrlTest extends TestCase
{

    public function testCreates(): void
    {
        $i1 = InstanceUrl::create();
        $this->assertEquals('https://hyvor.com', $i1->url);

        $i2 = InstanceUrl::create('https://example.com');
        $this->assertEquals('https://example.com', $i2->url);

        $i3 = InstanceUrl::createPrivate();
        $this->assertEquals('https://hyvor.com', $i3->url);

        config(['internal.private_instance' => 'https://hyvor.cluster']);
        $i4 = InstanceUrl::createPrivate();
        $this->assertEquals('https://hyvor.cluster', $i4->url);
    }

    public function testComponentUrl(): void
    {
        $instanceUrl = InstanceUrl::create();
        $this->assertEquals('https://hyvor.com', $instanceUrl->componentUrl(ComponentType::CORE));
        $this->assertEquals('https://talk.hyvor.com', $instanceUrl->componentUrl(ComponentType::TALK));

        // two levels deep
        $instanceUrl = InstanceUrl::create('https://hyvor.example.org');
        $this->assertEquals('https://hyvor.example.org', $instanceUrl->componentUrl(ComponentType::CORE));
        $this->assertEquals('https://talk.hyvor.example.org', $instanceUrl->componentUrl(ComponentType::TALK));
    }

}
