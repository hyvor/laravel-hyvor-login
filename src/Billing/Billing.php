<?php

namespace Hyvor\Internal\Billing;

use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\InternalApi\Exceptions\InternalApiCallFailedException;
use Hyvor\Internal\InternalApi\InternalApi;
use Hyvor\Internal\InternalApi\InternalApiMethod;

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
        int $userId,
        string $resourceType,
        ?int $resourceId,
        string $resourceName,
        float $monthlyPrice,
        bool $isAnnual,
        string $name,
        string $nameReadable,
        ComponentType $component = null,
    ): array {
        // validate decimal points
        if (str_contains((string)$monthlyPrice, '.')) {
            $decimalPoints = strlen(explode('.', (string)$monthlyPrice)[1]);
            if ($decimalPoints > 2) {
                throw new \InvalidArgumentException('Monthly price can have up to 2 decimal points');
            }
        }

        $component ??= ComponentType::current();

        $object = new InternalNewSubscription(
            $userId,
            $resourceType,
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
     * @param int|null $userId The ID of the user to get the subscription of. Only required if resource_id is `null`.
     * @param ComponentType|null $component The component to get the subscription from. Defaults to the current component.
     * @throws InternalApiCallFailedException
     */
    public static function getSubscription(
        ?int $resourceId = null,
        ?int $userId = null,
        ComponentType $component = null,
        bool $throw = false
    ): ?InternalSubscription {
        if ($resourceId === null && $userId === null) {
            throw new \InvalidArgumentException('Either user_id or resource_id must be provided');
        }

        $component ??= ComponentType::current();

        try {
            $response = InternalApi::call(
                ComponentType::CORE,
                InternalApiMethod::GET,
                '/billing/subscription',
                [
                    'user_id' => $userId,
                    'component' => $component,
                    'resource_id' => $resourceId,
                ]
            );
        } catch (InternalApiCallFailedException $e) {
            if ($throw) {
                throw $e;
            }
            return null;
        }

        if ($response['has_subscription']) {
            return InternalSubscription::fromArray($response['subscription']);
        }

        return null;
    }

    public static function getSubscriptionOfUser(
        int $userId,
        string $resourceType,
        ?int $resourceId,
        ComponentType $component = null,
        bool $throw = false
    ): ?InternalSubscription
    {
        $component ??= ComponentType::current();

        try {
            $response = InternalApi::call(
                ComponentType::CORE,
                InternalApiMethod::POST,
                '/billing/subscription',
                [
                    'user_id' => $userId,
                    'component' => $component,
                    'resource_type' => $resourceType,
                    'resource_id' => $resourceId,
                ]
            );
        } catch (InternalApiCallFailedException $e) {
            if ($throw) {
                throw $e;   // TODO: Throw a custom Exception
            }
            return null;
        }

        if ($response['has_subscription']) {
            return InternalSubscription::fromArray($response['subscription']);
        }

        return null;
    }

    public static function getSubscriptionOfResource(
        string $resourceType,
        ?int $resourceId,
        ComponentType $component = null,
        bool $throw = false
    ): ?InternalSubscription
    {
        $component ??= ComponentType::current();

        try {
            $response = InternalApi::call(
                ComponentType::CORE,
                InternalApiMethod::POST,
                '/billing/subscription',
                [
                    'component' => $component,
                    'resource_type' => $resourceType,
                    'resource_id' => $resourceId,
                ]
            );
        } catch (InternalApiCallFailedException $e) {
            if ($throw) {
                throw $e;   // TODO: Throw a custom Exception
            }
            return null;
        }

        if ($response['has_subscription']) {
            return InternalSubscription::fromArray($response['subscription']);
        }

        return null;
    }


    /**
     * @param int[] $userIds
     * @return InternalSubscription[]
     */
    public static function getSubscriptionsOfUsers(
        array $userIds,
        ?string $resourceType,
        ComponentType $component = null,
        bool $throw = false
    ): ?array
    {
        $component ??= ComponentType::current();

        try {
            $response = InternalApi::call(
                ComponentType::CORE,
                InternalApiMethod::POST,
                '/billing/subscriptions',
                [
                    'component' => $component,
                    'user_ids' => $userIds,
                    'resource_type' => $resourceType,
                ]
            );
        } catch (InternalApiCallFailedException $e) {
            if ($throw) {
                throw $e;   // TODO: Throw a custom Exception
            }
            return [];
        }

        if ($response['has_subscriptions']) {
            // TODO: Handle accordingly
            return array_map(
                fn($subscription) => InternalSubscription::fromArray($subscription),
                $response['subscriptions']
            );
        }

        return [];
    }

    /**
     * @param int[] $resourceIds
     * @return InternalSubscription[]
     */
    public static function getSubscriptionsOfResources(
        string $resourceType,
        array $resourceIds,
        ComponentType $component = null,
        bool $throw = false
    ): ?array
    {
        $component ??= ComponentType::current();

        try {
            $response = InternalApi::call(
                ComponentType::CORE,
                InternalApiMethod::POST,
                '/billing/subscriptions',
                [
                    'component' => $component,
                    'resource_type' => $resourceType,
                    'resource_ids' => $resourceIds,
                ]
            );
        } catch (InternalApiCallFailedException $e) {
            if ($throw) {
                throw $e;   // TODO: Throw a custom Exception
            }
            return [];
        }

        if ($response['has_subscriptions']) {
            // TODO: Handle accordingly
            return array_map(
                fn($subscription) => InternalSubscription::fromArray($subscription),
                $response['subscriptions']
            );
        }

        return [];
    }
}
