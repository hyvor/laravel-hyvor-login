<?php

namespace Hyvor\Internal\Billing\Plan;

use Hyvor\Internal\Billing\FeatureBag\BlogsFeatureBag;

enum BlogsPlans : string implements PlanInterface
{

    case STARTER = 'starter';
    case GROWTH = 'growth';
    case PREMIUM = 'premium';


    public function getMonthlyPrice(): float
    {
        return match ($this) {
            self::STARTER => 12,
            self::GROWTH => 40,
            self::PREMIUM => 125,
        };
    }

    public function toReadableString(): string
    {
        return match ($this) {
            self::STARTER => 'Starter',
            self::GROWTH => 'Growth',
            self::PREMIUM => 'Premium',
        };
    }

    public function getFeatureBag(): BlogsFeatureBag
    {

        return match ($this) {

            self::STARTER => new BlogsFeatureBag(
                users: 2,
                storageGb: 1,
                analyses: false,
                noBranding: false,
            ),

            self::GROWTH => new BlogsFeatureBag(
                users: 5,
                storageGb: 40,
                analyses: true,
                noBranding: true,
            ),

            self::PREMIUM => new BlogsFeatureBag(
                users: 15,
                storageGb: 250,
                analyses: true,
                noBranding: true,
            ),

        };

    }
}