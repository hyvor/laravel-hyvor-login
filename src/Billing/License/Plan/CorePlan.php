<?php

namespace Hyvor\Internal\Billing\License\Plan;

use Hyvor\Internal\Billing\License\CoreLicense;

/**
 * @extends PlanAbstract<CoreLicense>
 */
class CorePlan extends PlanAbstract
{

    protected function config(): void
    {
        $this->version(1, function () {
        });
    }

}
