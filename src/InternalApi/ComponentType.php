<?php

namespace Hyvor\Internal\InternalApi;

use Hyvor\Internal\Billing\Feature\Bag\BlogsFeatureBag;
use Hyvor\Internal\Billing\Feature\Bag\CoreFeatureBag;
use Hyvor\Internal\Billing\Feature\Bag\FeatureBag;
use Hyvor\Internal\Billing\Feature\Bag\TalkFeatureBag;
use Hyvor\Internal\Billing\Feature\Plan\BlogsPlans;
use Hyvor\Internal\Billing\Feature\Plan\PlanInterface;

enum ComponentType : string
{
    case CORE = 'core';
    case TALK = 'talk';
    case BLOGS = 'blogs';

    public function name() : string
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
    public static function fromConfig() : self
    {
        $config = config('internal.component');
        return self::from($config);
    }

    public static function current() : self
    {
        $config = config('internal.component');
        return self::from($config);
    }

    public function getCoreUrl() : string
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

    public function getUrlOfFrom(self $type) : string
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

    public static function getUrlOf(self $type) : string
    {
        return self::current()->getUrlOfFrom($type);
    }


    /**
     * @return class-string<FeatureBag>
     */
    public function featureBag(): string
    {

        return match ($this) {
            self::CORE => CoreFeatureBag::class,
            self::TALK => TalkFeatureBag::class,
            self::BLOGS => BlogsFeatureBag::class,
        };

    }

    /**
     * @return class-string<PlanInterface&\BackedEnum>|null
     */
    public function plans(): ?string
    {

        return match ($this) {
            self::CORE, self::TALK => null,
            self::BLOGS => BlogsPlans::class,
        };

    }

}