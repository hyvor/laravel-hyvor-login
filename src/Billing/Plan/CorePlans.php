<?php

namespace Hyvor\Internal\Billing\Plan;

use Hyvor\Internal\Billing\FeatureBag\FeatureBag;
use Hyvor\Internal\Billing\FeatureBag\TalkFeatureBag;

enum CorePlans  : string implements PlanInterface
{

    public function getMonthlyPrice(): float
    {
        return 0.0;
    }

    public function getFeatureBag(): FeatureBag
    {
        return new TalkFeatureBag();
    }

    public function toReadableString(): string
    {
        return '';
    }
}