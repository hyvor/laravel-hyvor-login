<?php

namespace Hyvor\Internal\Tests\Feature\ServiceProvider;

use Hyvor\Internal\Auth\Providers\Fake\AuthFake;
use Hyvor\Internal\Auth\Providers\Hyvor\HyvorAuthProvider;
use Hyvor\Internal\Auth\Providers\AuthProviderInterface;
use Hyvor\Internal\Billing\Billing;
use Hyvor\Internal\Billing\License\BlogsLicense;
use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalServiceProvider;
use Illuminate\Support\Collection;

class FakeTest extends \Orchestra\Testbench\TestCase
{

    private function bootServiceProvider(): void
    {
        $app = $this->app;
        assert($app !== null);
        $sp = new InternalServiceProvider($app);
        $sp->boot();
    }

    private function getApp(): \Illuminate\Foundation\Application
    {
        $app = $this->app;
        assert($app !== null);
        return $app;
    }

    public function testFakes(): void
    {
        config(['app.env' => 'local']);
        config(['internal.fake' => true]);

        $this->bootServiceProvider();

        // auth
        $app = $this->getApp();
        $authInstance = $app->get(AuthProviderInterface::class);
        $this->assertInstanceOf(AuthFake::class, $authInstance);
        $this->assertEquals(1, $authInstance->user?->id);

        // billing
        $this->assertTrue($app->bound(Billing::class));
        $license = $app->get(Billing::class)->license(1, null, ComponentType::BLOGS);
        $this->assertInstanceOf(BlogsLicense::class, $license);
        $this->assertEquals(2, $license->users);
    }

    public function testDoesNotFakeIfNotEnabled(): void
    {
        config(['app.env' => 'local']);
        $this->bootServiceProvider();
        $this->assertNotFaked();
    }

    public function testDoesNotFakeIfNotLocal(): void
    {
        config(['app.env' => 'production']);
        config(['internal.fake' => true]);
        $this->bootServiceProvider();
        $this->assertNotFaked();
    }

    private function assertNotFaked(): void
    {
        $app = $this->app;
        assert($app !== null);
        $this->assertInstanceOf(HyvorAuthProvider::class, $app->get(AuthProviderInterface::class));
        $this->assertFalse($app->bound(Billing::class));
    }

    public function testUsesExtendedClassIfThatIsAvailable(): void
    {
        config(['app.env' => 'local']);
        config(['internal.fake' => true]);

        // adds the extended class
        include 'internalfakextended.php';

        $app = $this->app;
        assert($app !== null);
        $sp = new InternalServiceProvider($app);
        $sp->boot();

        // user
        $authInstance = $app->get(AuthProviderInterface::class);
        $this->assertInstanceOf(AuthFake::class, $authInstance);
        $this->assertNull($authInstance->user);

        // billing
        $this->assertTrue($app->bound(Billing::class));
        $license = $app->get(Billing::class)->license(1, null, ComponentType::BLOGS);
        $this->assertInstanceOf(BlogsLicense::class, $license);
        $this->assertEquals(3, $license->users);
    }

}
