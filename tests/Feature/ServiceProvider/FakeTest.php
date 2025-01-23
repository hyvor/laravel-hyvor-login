<?php

namespace Hyvor\Internal\Tests\Feature\ServiceProvider;

use Hyvor\Internal\Auth\Providers\Fake\FakeProvider;
use Hyvor\Internal\Billing\Billing;
use Hyvor\Internal\Billing\License\BlogsLicense;
use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalFake;
use Hyvor\Internal\InternalServiceProvider;
use Illuminate\Support\Collection;

class FakeTest extends \Orchestra\Testbench\TestCase
{

    public function testFakes(): void
    {

        config(['app.env' => 'local']);

        $app = $this->app;
        assert($app !== null);
        $sp = new InternalServiceProvider($app);
        $sp->boot();

        $this->assertTrue($app->bound('Hyvor\Internal\Billing\Billing'));

        // auth
        $this->assertEquals('fake', config('internal.auth.provider'));
        $this->assertEquals(1, config('internal.auth.fake.user_id'));
        $this->assertInstanceOf(Collection::class, FakeProvider::$DATABASE);
        $this->assertCount(1, FakeProvider::$DATABASE);

        // billing
        $license = $app->get(Billing::class)->license(1, null, ComponentType::BLOGS);
        $this->assertInstanceOf(BlogsLicense::class, $license);
        $this->assertEquals(2, $license->users);

    }

    public function testDoesNotFakeIfNotEnabled(): void
    {

        config(['app.env' => 'local']);

        InternalFake::$ENABLED = false;

        assert($this->app !== null);
        $sp = new InternalServiceProvider($this->app);
        $sp->boot();

        $this->assertFalse($this->app->bound('Hyvor\Internal\Billing\Billing'));

        InternalFake::$ENABLED = true; // reset

    }

    public function testUsesExtendedClassIfThatIsAvailable(): void
    {

        config(['app.env' => 'local']);

        // adds the extended class
        include 'internalfakextended.php';

        $app = $this->app;
        assert($app !== null);
        $sp = new InternalServiceProvider($app);
        $sp->boot();

        $this->assertTrue($app->bound('Hyvor\Internal\Billing\Billing'));

        // user
        $this->assertEquals('fake', config('internal.auth.provider'));
        $this->assertNull(config('internal.auth.fake.user_id'));
        $this->assertInstanceOf(Collection::class, FakeProvider::$DATABASE);
        $this->assertCount(0, FakeProvider::$DATABASE);

        // billing
        $license = $app->get(Billing::class)->license(1, null, ComponentType::BLOGS);
        $this->assertInstanceOf(BlogsLicense::class, $license);
        $this->assertEquals(3, $license->users);

    }

}
