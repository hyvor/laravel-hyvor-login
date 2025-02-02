<?php

namespace Hyvor\Internal\Types\tests\data;

class CustomLicense extends \Hyvor\Internal\Billing\License\License
{
    public function __construct(
        public int $limit,
        public bool $option,
        public string $myBadLimit,
    ) {
    }
}
