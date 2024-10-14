<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\Util\Crypt\Encryptable;

class ObjectNewSubscription
{

    use Encryptable;

    public function __construct(
        public ?int $resourceId,
        public ?string $resourceName,
        public float $monthlyPrice,
        public bool $isAnnual,
        public string $name,
        public string $nameReadable,
        public ComponentType $component,
    ) {}


}