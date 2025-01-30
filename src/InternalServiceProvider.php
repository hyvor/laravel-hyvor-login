<?php

namespace Hyvor\Internal;

use Hyvor\Internal\Auth\Providers\CurrentProvider;
use Hyvor\Internal\Auth\Providers\Fake\AuthFake;
use Hyvor\Internal\Auth\Providers\Hyvor\HyvorAuthProvider;
use Hyvor\Internal\Billing\BillingFake;
use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\Resource\ResourceFake;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class InternalServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        if (config('internal.auth.routes')) {
            $this->loadRoutesFrom(__DIR__ . '/routes/auth.php');
        }

        if (App::environment('testing')) {
            $this->loadRoutesFrom(__DIR__ . '/routes/testing.php');
        }

        // set auth provider
        CurrentProvider::set(HyvorAuthProvider::class);

        if (
            config('app.env') === 'local' &&
            config('internal.fake')
        ) {
            $this->fake();
        }
    }

    private function fake(): void
    {
        $class = InternalFake::class;

        if (class_exists('Hyvor\Internal\InternalFakeExtended')) {
            $class = 'Hyvor\Internal\InternalFakeExtended';
        }

        /** @var class-string<InternalFake> $class */
        $fakeConfig = new $class;

        // fake auth
        $user = $fakeConfig->user();
        AuthFake::enable($user);

        // fake billing
        BillingFake::enable(license: function (int $userId, ?int $resourceId, ComponentType $component) use ($fakeConfig
        ) {
            return $fakeConfig->license($userId, $resourceId, $component);
        });

        // fake resource
        ResourceFake::enable();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'internal');
    }

}
