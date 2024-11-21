<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\Util\Array\Arrayable;
use Hyvor\Internal\Util\Crypt\Encryptable;

class InternalSubscription
{

    use Arrayable;
    use Encryptable;

    public int $id;
    public int $created_at;
    public SubscriptionStatus $status;
    public int $user_id;
    public bool $is_annual;
    public ComponentType $component;
    public ?int $resource_id;
    public float $monthly_price;
    public string $name;
    public string $name_readable;

}