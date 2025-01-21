<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\Billing\License\License;
use Hyvor\Internal\InternalApi\ComponentType;

class BillingFake extends Billing
{

    public function __construct(
        /**
         * @param License|(callable(int $userId, ?int $blogId, ComponentType $component) : License)|null $license
         * null for default license
         * License to return a custom license
         * Closure to return a custom license dynamically
         */
        private readonly mixed $license = null
    )
    {
    }

    public function subscriptionIntent(int $userId, float $monthlyPrice, bool $isAnnual, string $planName, ?ComponentType $component = null): array
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
            // default license with trial defaults
            return new ($component->license());
        }

        return ($this->license)($userId, $resourceId, $component);
    }

}
