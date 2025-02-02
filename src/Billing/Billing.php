<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\Billing\License\License;
use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalApi\InstanceUrl;
use Hyvor\Internal\InternalApi\InternalApi;
use Hyvor\Internal\InternalApi\InternalApiMethod;

class Billing
{

    /**
     * @return array{token: string, urlNew: string, urlChange: string}
     * @see SubscriptionIntent
     */
    public function subscriptionIntent(
        int $userId,
        string $planName,
        bool $isAnnual,
        ?ComponentType $component = null,
    ): array {
        $component ??= ComponentType::current();

        // this validates the plan name as well
        $plan = $component->plans()->getPlan($planName);

        $object = new SubscriptionIntent(
            $component,
            $plan->version,
            $planName,
            $userId,
            $plan->monthlyPrice,
            $isAnnual,
        );

        $token = $object->encrypt();

        $baseUrl = InstanceUrl::getInstanceUrl() . '/account/billing/subscription?token=' . $token;

        return [
            'token' => $token,
            'urlNew' => $baseUrl,
            'urlChange' => $baseUrl . '&change=1',
        ];
    }

    /**
     * Get the license of a user.
     */
    public function license(
        int $userId,
        ?int $resourceId,
        ?ComponentType $component = null,
    ): ?License {
        $component ??= ComponentType::current();

        $response = InternalApi::call(
            ComponentType::CORE,
            InternalApiMethod::GET,
            '/billing/license',
            [
                'user_id' => $userId,
                'resource_id' => $resourceId,
            ],
            $component
        );

        /** @var ?string $license */
        $license = $response['license'];
        $licenseClass = $component->license();

        return $license ? $licenseClass::unserialize($license) : null;
    }

}
