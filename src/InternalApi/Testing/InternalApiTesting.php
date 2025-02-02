<?php

namespace Hyvor\Internal\InternalApi\Testing;

use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalApi\InternalApiMethod;

/**
 * Use this class to test the internal API calls of a component
 * @deprecated
 * @codeCoverageIgnore
 */
class InternalApiTesting
{

    /**
     * @param array<mixed> $data
     * @param InternalApiMethod|'GET'|'POST' $method
     * @deprecated Use CallsInternalAPI trait instead
     * @deprecated
     */
    public static function call(
        InternalApiMethod|string $method,
        string $endpoint,
        array $data = [],
        ?ComponentType $from = null,
    ): never {
        throw new \Exception('This method is deprecated. Use the CallsInternalAPI trait instead');
    }

}
