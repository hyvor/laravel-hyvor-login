<?php

declare(strict_types=1);

namespace Hyvor\Internal\Auth\Providers;

class CurrentProvider
{

    /**
     * @param class-string<AuthProviderInterface>|AuthProviderInterface $provider
     */
    public static function set(string|object $provider): void
    {
        app()->singleton(AuthProviderInterface::class, is_string($provider) ? $provider : fn() => $provider);
    }

    public static function get(): AuthProviderInterface
    {
        return app(AuthProviderInterface::class);
    }

}
