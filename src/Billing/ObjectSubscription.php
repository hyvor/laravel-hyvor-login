<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\InternalApi\ComponentType;

class ObjectSubscription
{

    public int $id;
    public SubscriptionStatus $status;
    public int $user_id;
    public bool $is_annual;
    public ComponentType $component;
    public ?int $resource_id;
    public float $monthly_price;
    public string $name;
    public string $name_readable;

}