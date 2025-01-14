<?php

namespace Hyvor\Internal\Billing\Plan;

use Hyvor\Internal\Billing\FeatureBag\FeatureBag;

interface PlanInterface
{

    public function getFeatureBag(): FeatureBag;

}