<?php

namespace Hyvor\Internal\Billing\Feature\Plan;

use Hyvor\Internal\Billing\Feature\Bag\FeatureBag;

interface PlanInterface
{

    public function getFeatureBag(): FeatureBag;

}