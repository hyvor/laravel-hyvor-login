<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\InternalApi\ComponentType;

class Billing
{

    /**
     * Generates a token for a new subscription and returns the URL to create a new subscription.
     * @param int|null $resourceId The ID of the resource to subscribe (blog ID in HB). `null` for account-wide subscriptions.
     * @param float $monthlyPrice The monthly price of the subscription in EUR. Up to 2 decimal points.
     * @param bool $isAnnual Whether the subscription is annual.
     * @param string $name The name of the subscription (plan name: "Premium")
     * @return array{token: string, redirect: string}
     */
    public static function newSubscription(
        ?int $resourceId,
        string $resourceName,
        float $monthlyPrice,
        bool $isAnnual,
        string $name,
        string $nameReadable,
        ComponentType $component = null,
    ) : array
    {

        // validate decimal points
        if (str_contains((string)$monthlyPrice, '.')) {
            $decimalPoints = strlen(explode('.', (string) $monthlyPrice)[1]);
            if ($decimalPoints > 2) {
                throw new \InvalidArgumentException('Monthly price can have up to 2 decimal points');
            }
        }

        $component ??= ComponentType::current();

        $object = new ObjectNewSubscription(
            $resourceId,
            $resourceName,
            $monthlyPrice,
            $isAnnual,
            $name,
            $nameReadable,
            $component,
        );

        $token = $object->encrypt();

        return [
            'token' => $token,
            'redirect' => ComponentType::getUrlOf(ComponentType::CORE) . '/account/billing/new?token=' . $token
        ];
    }

    /**
     * Returns the active subscription of a resource.
     *
     * @param int|null $resourceId The ID of the resource to get the subscription of. `null` for account-wide subscriptions.
     * @param ComponentType|null $component The component to get the subscription from. Defaults to the current component.
     */
    public static function getSubscription(
        ?int $resourceId,
        ComponentType $component = null,
    ) : ?ObjectSubscription
    {

        $component ??= ComponentType::current();

    }

}