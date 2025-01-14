<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\Billing\FeatureBag\FeatureBag;
use Hyvor\Internal\Billing\Plan\PlanInterface;
use Hyvor\Internal\InternalApi\ComponentType;

/**
 * @template TFeatures of FeatureBag = FeatureBag
 * @template TPlan of PlanInterface|null = PlanInterface|null
 */
class ActiveSubscription
{

    /**
     * @var TFeatures
     */
    public FeatureBag $features;
    public float $monthlyPrice;
    public float $annualPrice;
    public bool $isAnnual;

    /**
     * @var TPlan|null
     */
    public ?PlanInterface $plan;

    /**
     * @param array{
     *     monthly_price: float,
     *     annual_price: float,
     *     is_annual: bool,
     *     plan: string|null,
     *     features: array<string, mixed>,
     * } $data
     */
    public static function fromArray(ComponentType $component, array $data): self
    {
        $subscription = new self();
        $subscription->monthlyPrice = $data['monthly_price'];
        $subscription->annualPrice = $data['annual_price'];
        $subscription->isAnnual = $data['is_annual'];

        $componentPlans = $component->plans();
        $subscription->plan =
            is_string($data['plan']) && $componentPlans ?
            $componentPlans::tryFrom($data['plan']) :
            null;

        $subscription->features = $component->featureBag()::fromArray($data['features']);

        return $subscription;
    }

}