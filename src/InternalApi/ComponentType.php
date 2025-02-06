<?php

namespace Hyvor\Internal\InternalApi;

use Hyvor\Internal\Billing\License\BlogsLicense;
use Hyvor\Internal\Billing\License\CoreLicense;
use Hyvor\Internal\Billing\License\License;
use Hyvor\Internal\Billing\License\Plan\BlogsPlan;
use Hyvor\Internal\Billing\License\Plan\CorePlan;
use Hyvor\Internal\Billing\License\Plan\PlanAbstract;
use Hyvor\Internal\Billing\License\Plan\TalkPlan;
use Hyvor\Internal\Billing\License\TalkLicense;

enum ComponentType: string
{
    case CORE = 'core';
    case TALK = 'talk';
    case BLOGS = 'blogs';

    public function name(): string
    {
        return match ($this) {
            self::CORE => 'HYVOR',
            self::TALK => 'Hyvor Talk',
            self::BLOGS => 'Hyvor Blogs',
        };
    }

    /**
     * @deprecated
     * @codeCoverageIgnore
     */
    public static function fromConfig(): self
    {
        $config = config('internal.component');
        return self::from($config);
    }

    public static function current(): self
    {
        $config = config('internal.component');
        return self::from($config);
    }

    /**
     * @deprecated Use InstanceUrl::componentUrl instead
     */
    public function getCoreUrl(): string
    {
        $currentUrl = config('internal.instance');

        if ($this === ComponentType::CORE) {
            return $currentUrl;
        } else {
            $protocol = strval(parse_url($currentUrl, PHP_URL_SCHEME)) . '://';
            $host = strval(parse_url($currentUrl, PHP_URL_HOST));

            $componentSubdomain = $this->value;
            $coreHost = preg_replace('/^' . $componentSubdomain . '\./', '', $host);

            return $protocol . $coreHost;
        }
    }

    /**
     * @deprecated Use InstanceUrl::componentUrl instead
     */
    public function getUrlOfFrom(self $type): string
    {
        $coreUrl = $this->getCoreUrl();

        if ($type === self::CORE) {
            return $coreUrl;
        } else {
            $subdomain = $type->value;

            $coreHost = parse_url($coreUrl, PHP_URL_HOST);
            $protocol = parse_url($coreUrl, PHP_URL_SCHEME) . '://';

            return $protocol . $subdomain . '.' . $coreHost;
        }
    }

    /**
     * @deprecated Use InstanceUrl::componentUrl instead
     */
    public static function getUrlOf(self $type): string
    {
        return self::current()->getUrlOfFrom($type);
    }

    /**
     * @return class-string<License>
     */
    public function license(): string
    {
        return match ($this) {
            self::CORE => CoreLicense::class,
            self::TALK => TalkLicense::class,
            self::BLOGS => BlogsLicense::class,
        };
    }

    public function plans(): PlanAbstract
    {
        $class = match ($this) {
            self::CORE => CorePlan::class,
            self::TALK => TalkPlan::class,
            self::BLOGS => BlogsPlan::class,
        };

        return new $class();
    }

}
