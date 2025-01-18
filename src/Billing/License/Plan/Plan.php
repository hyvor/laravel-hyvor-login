<?php

namespace Hyvor\Internal\Billing\License\Plan;

use Hyvor\Internal\Billing\License\License;

class Plan
{

    public function __construct(
        public string  $name,
        public float   $monthlyPrice,
        public License $licence,

        /**
         * If the readable name is simply capitalized $name, you can leave this null.
         */
        public ?string $nameReadable = null,
    )
    {
    }

}