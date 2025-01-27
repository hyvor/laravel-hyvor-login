<?php

namespace Hyvor\Internal;

use Hyvor\Internal\Auth\AuthUser;
use Hyvor\Internal\Billing\License\License;
use Hyvor\Internal\InternalApi\ComponentType;

class InternalFake
{

    public static bool $ENABLED = true;

    /**
     * It returns a default user with id 1.
     */
    public function user(): ?AuthUser
    {
        return AuthUser::fromArray([
            'id' => 1,
            'username' => 'alex',
            'name' => 'Alex Dornan',
            'email' => 'alex@hyvor.com',
            'picture_url' => 'https://picsum.photos/100/100',
        ]);
    }

    /**
     * Returns a default (trial) license of the component
     */
    public function license(int $userId, ?int $resourceId, ComponentType $component): ?License
    {
        $licenseClass = $component->license();
        return new $licenseClass; // trial defaults
    }

}
