<?php

namespace Hyvor\Internal\Billing\License\Plan;

use Hyvor\Internal\Billing\License\License;

class Plan
{

    public string $nameReadable;

    public function __construct(
        public int     $version,
        public string  $name,
        public float   $monthlyPrice,
        public License $license,

        /**
         * If the readable name is simply capitalized $name, you can leave this null.
         */
        ?string        $nameReadable = null,
    )
    {
        $this->nameReadable = $nameReadable ?? ucfirst($this->name);
    }

    public function getReadableName(): string
    {
        return $this->nameReadable;
    }

}
