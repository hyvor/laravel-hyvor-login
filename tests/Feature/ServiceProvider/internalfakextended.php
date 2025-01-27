<?php

namespace Hyvor\Internal;

use Hyvor\Internal\Auth\AuthUser;
use Hyvor\Internal\Billing\License\BlogsLicense;
use Hyvor\Internal\Billing\License\License;
use Hyvor\Internal\InternalApi\ComponentType;

class InternalFakeExtended extends InternalFake
{

    public function user(): ?AuthUser
    {
        return null;
    }

    public function license(int $userId, ?int $resourceId, ComponentType $component): ?License
    {
        return new BlogsLicense(users: 3);
    }

}
