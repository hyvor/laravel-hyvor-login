<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\Billing\Plan\PlanInterface;
use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalApi\Exceptions\InternalApiCallFailedException;
use Hyvor\Internal\InternalApi\InternalApi;
use Hyvor\Internal\InternalApi\InternalApiMethod;

class Billing
{

    /**
     * @see SubscriptionIntent
     * @return array{token: string, urlNew: string, urlChange: string}
     */
    public static function subscriptionIntent(
        int $userId,
        float $monthlyPrice,
        bool $isAnnual,
        PlanInterface&\BackedEnum $plan,
        ?ComponentType $component = null,
    ): array {
        $component ??= ComponentType::current();


        // validate decimal points
        if (str_contains((string)$monthlyPrice, '.')) {
            $decimalPoints = strlen(explode('.', (string)$monthlyPrice)[1]);
            if ($decimalPoints > 2) {
                throw new \InvalidArgumentException('Monthly price can have up to 2 decimal points');
            }
        }

        // validate plan name
        if ($component->plans()::tryFrom($plan->value) === null) {
            throw new \InvalidArgumentException("Invalid plan name: {$plan->value}");
        }

        $object = new SubscriptionIntent(
            $component,
            $userId,
            $monthlyPrice,
            $isAnnual,
            (string) $plan->value,
        );

        $token = $object->encrypt();

        $baseUrl = ComponentType::getUrlOf(ComponentType::CORE) . '/account/billing/subscription?token=' . $token;

        return [
            'token' => $token,
            'urlNew' => $baseUrl,
            'urlChange' => $baseUrl . '&change=1',
        ];
    }

    /**
     * If the product has account-level subscriptions,
     * use this method to get the subscription of a user.
     *
     * Dynamic return types: Hyvor\Internal\PHPStan\BillingGetSubscriptionReturnTypeExtension
     *
     * @deprecated
     * @param ComponentType $component The component (product) to get the subscription of. Required for type safety.
     * @param int $userId The ID of the user to get the subscription of.
     * @return ActiveSubscription|null If the user has an active subscription, it will be returned. Otherwise, null.
     * @throws InternalApiCallFailedException
     */
    public static function getSubscriptionOfUser(ComponentType $component, int $userId): ?ActiveSubscription
    {

        $response = InternalApi::call(
            ComponentType::CORE,
            InternalApiMethod::GET,
            '/billing/subscription',
            [
                'component' => $component,
                'user_id' => $userId,
            ]
        );

        $subscription = $response['subscription'];

        return $subscription ? ActiveSubscription::fromArray($component, $subscription) : null;

    }

    /**
     * Get the active subscription of a resource (e.g., a blog).
     *
     * Dynamic return types: Hyvor\Internal\PHPStan\BillingGetSubscriptionReturnTypeExtension
     *
     * @param ComponentType $component The component (product) to get the subscription of. Required for type safety.
     * @param int $resourceId The ID of the resource to get the subscription of.
     * @return ActiveSubscription|null If the user has an active subscription, it will be returned. Otherwise, null.
     * @throws InternalApiCallFailedException
     */
    public static function getSubscriptionOfResource(ComponentType $component, int $resourceId): ?ActiveSubscription
    {

        $response = InternalApi::call(
            ComponentType::CORE,
            InternalApiMethod::GET,
            '/billing/subscription',
            [
                'component' => $component,
                'resource_id' => $resourceId,
            ]
        );

        $subscription = $response['subscription'];

        return $subscription ? ActiveSubscription::fromArray($component, $subscription) : null;

    }

}
