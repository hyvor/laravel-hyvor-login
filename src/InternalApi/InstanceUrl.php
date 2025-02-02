<?php

namespace Hyvor\Internal\InternalApi;

class InstanceUrl
{

    public string $url;

    public function __construct(?string $customUrl = null)
    {
        $this->url = $customUrl ?? self::getInstanceUrl();
    }

    public function componentUrl(ComponentType $component): string
    {
        $instanceUrl = $this->url;

        if ($component === ComponentType::CORE) {
            return $instanceUrl;
        } else {
            $subdomain = $component->value;

            $coreHost = parse_url($instanceUrl, PHP_URL_HOST);
            $protocol = parse_url($instanceUrl, PHP_URL_SCHEME) . '://';

            return $protocol . $subdomain . '.' . $coreHost;
        }
    }

    public static function create(?string $customUrl = null): self
    {
        return new self($customUrl);
    }

    public static function createPrivate(): self
    {
        return new self(self::getPrivateInstanceUrl());
    }

    // instanceUrl = coreUrl
    public static function getInstanceUrl(): string
    {
        return config()->string('internal.instance');
    }

    public static function getPrivateInstanceUrl(): ?string
    {
        $url = config()->get('internal.private_instance');

        if (is_string($url)) {
            return $url;
        }

        return null;
    }


}
