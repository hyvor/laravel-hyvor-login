<?php

namespace Hyvor\Internal\Bundle;

use Hyvor\Internal\Component\Component;

class InternalConfig
{

    public function __construct(

        /**
         * This is APP_KEY in laravel and APP_SECRET in symfony
         * It is in the Laravel format: base64:<key>
         */
        private readonly string $appSecret,

        /**
         * Component name
         */
        private readonly string $component,
        private readonly string $instance,
        private readonly ?string $privateInstance,
        private readonly bool $fake,
    ) {
    }

    // returns the app secret with the base64: prefix
    public function getAppSecretRaw(): string
    {
        return $this->appSecret;
    }

    public function getAppSecret(): string
    {
        return base64_decode(substr($this->appSecret, 7));
    }

    public function getComponent(): Component
    {
        return Component::from($this->component);
    }

    public function getInstance(): string
    {
        return $this->instance;
    }

    public function getPrivateInstance(): ?string
    {
        return $this->privateInstance;
    }

    public function getPrivateInstanceWithFallback(): string
    {
        return $this->privateInstance ?? $this->instance;
    }

    public function isFake(): bool
    {
        return $this->fake;
    }

}