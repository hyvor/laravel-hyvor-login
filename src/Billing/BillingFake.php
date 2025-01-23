<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\Billing\License\License;
use Hyvor\Internal\InternalApi\ComponentType;

class BillingFake extends Billing
{

    public function __construct(
        /**
         * @param License|(callable(int $userId, ?int $resouceId, ComponentType $component) : ?License)|null $license
         */
        private readonly mixed $license = null
    )
    {
    }

    public function subscriptionIntent(int $userId, string $planName, bool $isAnnual, ?ComponentType $component = null): array
    {
        return [
            'token' => '',
            'urlNew' => '',
            'urlChange' => '',
        ];
    }

    public function license(int $userId, ?int $resourceId, ?ComponentType $component = null): ?License
    {

        $component ??= ComponentType::current();

        if ($this->license instanceof License) {
            return $this->license;
        }

        if ($this->license === null) {
            return null;
        }

        return ($this->license)($userId, $resourceId, $component);
    }

}
