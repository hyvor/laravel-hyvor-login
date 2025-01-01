<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\Util\Crypt\Encryptable;

/**
 * This is the object for requesting a new subscription
 * or a plan change.
 */
class SubscriptionIntent
{

    use Encryptable;

    public function __construct(
        /**
         * User requesting the subscription
         */
        public int $userId,

        /**
         * Type of the resource
         * Ex: `account` in talk
         * Ex: `blog` or `custom_domain` in blogs
         * In the UI, this is shown as "Account" or "Blog" or "Custom Domain"
         */
        public string $resourceType,

        /**
         * ID of the resource, if the resource type has multiple resources
         * Ex: null in talk
         * Ex: blog ID in blogs
         */
        public ?int $resourceId,

        /**
         * Name that describes the resource
         */
        public ?string $resourceName,

        /**
         * Monthly price of the subscription
         */
        public float $monthlyPrice,

        /**
         * Is this an annual subscription?
         */
        public bool $isAnnual,

        /**
         * Name of the subscription plan.
         * Important:
         *  This should be unique for each resource type.
         *
         * Ex: `premium_1` in talk
         * Ex: `premium` in blogs
         */
        public string $name,

        /**
         * Readable name of the subscription plan.
         * This is shown in the UI.
         * Ex: `Premium 1M` in talk
         * Ex: `Premium` in blogs
         */
        public string $nameReadable,

        /**
         * Type of the component
         * Ex: `ComponentType::TALK` in talk
         * Ex: `ComponentType::BLOG` in blogs
         */
        public ComponentType $component,
    ) {}


}