<?php

namespace Hyvor\Internal\Billing\License\Plan;

use Hyvor\Internal\Billing\License\BlogsLicense;
use Hyvor\Internal\Billing\License\TalkLicense;

class TalkPlan extends PlanAbstract
{

    public function config(): void
    {
        // TODO:
        $this->version(1, function () {

            $this->plan(
                'premium_0.1',
                9,
                new TalkLicense(),
                nameReadable: 'Premium 100K',
            );

        });
    }
}
