<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\Util\Crypt\Encryptable;

class InternalNewSubscription
{

    use Encryptable;

    public function __construct(
        public int $userId,
        public ?int $resourceId,
        public ?string $resourceName,
        public float $monthlyPrice,
        public bool $isAnnual,
        public string $name,
        public string $nameReadable,
        public ComponentType $component,
    ) {}


}