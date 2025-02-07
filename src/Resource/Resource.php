<?php

namespace Hyvor\Internal\Resource;

use Carbon\Carbon;
use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalApi\InternalApi;
use Hyvor\Internal\InternalApi\InternalApiMethod;

class Resource
{

    public function register(
        int $userId,
        int $resourceId,
        ?Carbon $at = null
    ): void {
        InternalApi::call(
            ComponentType::CORE,
            InternalApiMethod::POST,
            '/resource/register',
            [
                'user_id' => $userId,
                'resource_id' => $resourceId,
                'at' => $at?->getTimestamp(),
            ]
        );
    }

    public function delete(int $resourceId): void
    {
        InternalApi::call(
            ComponentType::CORE,
            InternalApiMethod::POST,
            '/resource/delete',
            [
                'resource_id' => $resourceId,
            ]
        );
    }

}
