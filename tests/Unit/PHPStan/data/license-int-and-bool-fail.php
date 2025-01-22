<?php

class CustomLicense extends \Hyvor\Internal\Billing\License\License
{
    public function __construct(
        public int $limit,
        public bool $option,
        public string $myBadLimit,
    )
    {
    }
}
