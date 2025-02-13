<?php

namespace Hyvor\Internal\Bundle;

class InternalConfig
{

    public function __construct(
        private readonly string $component,
        private readonly string $instance,
        private readonly ?string $privateInstance,
        private readonly bool $fake,
    ) {
    }

    public function getComponent(): string
    {
        return $this->component;
    }

    public function getInstance(): string
    {
        return $this->instance;
    }

    public function getPrivateInstance(): ?string
    {
        return $this->privateInstance;
    }

    public function isFake(): bool
    {
        return $this->fake;
    }

}