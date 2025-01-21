<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\Billing\License\License;
use Hyvor\Internal\Billing\License\Plan\Plan;
use Hyvor\Internal\InternalApi\ComponentType;

/**
 * @deprecated
 */
class ActiveSubscription
{

    public ?Plan $plan;
    public License $license;
    public float $monthlyPrice;
    public float $annualPrice;
    public bool $isAnnual;

    /**
     * @param array{
     *     monthlyPrice: float,
     *     annualPrice: float,
     *     isAnnual: bool,
     *     plan: string|null,
     *     license: array<string, mixed>,
     * } $data
     */
    public static function fromArray(ComponentType $component, array $data): self
    {
        $subscription = new self();
        $subscription->monthlyPrice = $data['monthlyPrice'];
        $subscription->annualPrice = $data['annualPrice'];
        $subscription->isAnnual = $data['isAnnual'];

        $componentPlans = $component->plans();
        $subscription->plan =
            is_string($data['plan']) ?
            $componentPlans->getPlan($data['plan']) :
            null;

        $licenseClass = $component->license();
        $subscription->license = $licenseClass::fromArray($data['license']);

        return $subscription;
    }

}
