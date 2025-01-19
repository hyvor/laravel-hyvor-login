<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\Billing\License\Plan\Plan;
use Hyvor\Internal\InternalApi\ComponentType;

class ActiveSubscription
{

    public ?Plan $plan;

    /**
     * @var TFeatures
     */
    public FeatureBag $features;
    public float $monthlyPrice;
    public float $annualPrice;
    public bool $isAnnual;

    /**
     * @param array{
     *     monthlyPrice: float,
     *     annualPrice: float,
     *     isAnnual: bool,
     *     plan: string|null,
     *     features: array<string, mixed>,
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
            is_string($data['plan']) && $componentPlans ?
            $componentPlans::tryFrom($data['plan']) :
            null;

        $subscription->features = $component->featureBag()::fromArray($data['features']);

        return $subscription;
    }

}