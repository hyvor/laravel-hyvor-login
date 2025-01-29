<?php

declare(strict_types=1);

namespace Hyvor\Internal\Auth\Providers;

class CurrentProvider
{

    /**
     * @param class-string<ProviderInterface> $provider
     */
    public static function set(string $provider): void
    {
        app()->bind(ProviderInterface::class, $provider);
    }

    public static function get(): ProviderInterface
    {
        return app(ProviderInterface::class);
    }

}
