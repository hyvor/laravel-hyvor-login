<?php

namespace Hyvor\Internal\Billing\Plan;

use Hyvor\Internal\Billing\FeatureBag\FeatureBag;

interface PlanInterface
{

    public function getMonthlyPrice(): float;
    public function getFeatureBag(): FeatureBag;
    public function toReadableString(): string;

}