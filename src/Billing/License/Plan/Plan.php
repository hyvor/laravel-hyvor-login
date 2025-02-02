<?php

namespace Hyvor\Internal\Billing\License\Plan;

use Hyvor\Internal\Billing\License\License;

/**
 * @template T of License
 */
class Plan
{

    public string $nameReadable;

    public function __construct(
        public int $version,
        public string $name,
        public float $monthlyPrice,
        /**
         * @var T
         */
        public License $license,

        /**
         * If the readable name is simply capitalized $name, you can leave this null.
         */
        ?string $nameReadable = null,
    ) {
        $this->nameReadable = $nameReadable ?? ucfirst($this->name);
    }

}
