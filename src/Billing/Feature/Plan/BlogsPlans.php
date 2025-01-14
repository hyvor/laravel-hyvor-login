<?php

namespace Hyvor\Internal\Billing\Feature\Plan;

use Hyvor\Internal\Billing\Feature\Bag\BlogsFeatureBag;

enum BlogsPlans : string implements PlanInterface
{

    case STARTER = 'starter';
    case GROWTH = 'growth';
    case PREMIUM = 'premium';

    public function getFeatureBag(): BlogsFeatureBag
    {

        return match ($this) {

            self::STARTER => new BlogsFeatureBag(
                users: 2,
                storageGb: 1,
                analyses: false,
                noBranding: false,
                integrationHyvorTalk: false
            ),

            self::GROWTH => new BlogsFeatureBag(
                users: 5,
                storageGb: 40,
                analyses: true,
                noBranding: true,
                integrationHyvorTalk: true
            ),

            self::PREMIUM => new BlogsFeatureBag(
                users: 15,
                storageGb: 250,
                analyses: true,
                noBranding: true,
                integrationHyvorTalk: true
            ),

        };

    }
}