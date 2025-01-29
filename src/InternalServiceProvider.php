<?php

namespace Hyvor\Internal;

use Hyvor\Internal\Auth\Providers\Fake\FakeProvider;
use Hyvor\Internal\Billing\Billing;
use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\Laravel\Database\Command\DatabaseNukeCommand;
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

        if (
            config('app.env') === 'local' &&
            config('internal.fake')
        ) {
            $this->fake();
        }

        $this->commands([
            DatabaseNukeCommand::class
        ]);
    }

    private function fake(): void
    {

        $class = InternalFake::class;

        if (class_exists('Hyvor\Internal\InternalFakeExtended')) {
            $class = 'Hyvor\Internal\InternalFakeExtended';
        }

        /** @var class-string<InternalFake> $class */
        $fakeConfig = new $class;

        // fake user
        $user = $fakeConfig->user();
        config(['internal.auth.provider' => 'fake']);
        if ($user) {
            config(['internal.auth.fake.user_id' => $user->id]);
        }
        FakeProvider::databaseSet($user ? [$user] : []);

        // fake billing
        Billing::fake(license: function (int $userId, ?int $resourceId, ComponentType $component) use ($fakeConfig) {
            return $fakeConfig->license($userId, $resourceId, $component);
        });
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'internal');
    }

}
