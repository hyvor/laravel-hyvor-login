<?php

namespace Hyvor\Internal\InternalApi\Testing;

use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalApi\InternalApi;
use Hyvor\Internal\InternalApi\InternalApiMethod;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Testing\TestResponse;

trait CallsInternalApi
{

    /**
     * @param array<mixed> $data
     * @param InternalApiMethod|'GET'|'POST' $method
     * @return TestResponse<JsonResponse>
     */
    public function internalApi(
        InternalApiMethod|string $method,
        string                   $endpoint,
        array                    $data = [],
        ?ComponentType           $from = null,
    ): TestResponse
    {

        assert(App::environment('testing'), 'This method can only be called in the testing environment');

        if (is_string($method)) {
            $method = InternalApiMethod::from($method);
        }

        $endpoint = ltrim($endpoint, '/');

        return $this->call(
            $method->value,
            '/api/internal/' . $endpoint,
            [
                'message' => InternalApi::messageFromData($data),
            ],
            [],
            [],
            [
                'HTTP_X-Internal-Api-From' => ($from ?? ComponentType::CORE)->value,
                'HTTP_X-Internal-Api-To' => ComponentType::current()->value,
            ]
        );

    }

}
