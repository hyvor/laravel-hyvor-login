<?php

namespace Hyvor\Internal\Tests\Unit\Billing;


use Hyvor\Internal\Billing\Billing;
use Hyvor\Internal\Billing\SubscriptionStatus;
use Hyvor\Internal\InternalApi\ComponentType;
use Illuminate\Support\Facades\Http;

describe('get subscription', function() {

    it('no subscription', function() {

        Http::fake([
            'https://hyvor.com/api/internal/billing/subscription*' => Http::response([
                'has_subscription' => false,
            ])
        ]);

        $subscription = Billing::getSubscription(1);

        expect($subscription)->toBeNull();

    });

    it('with subscription', function() {

        Http::fake([
            'https://hyvor.com/api/internal/billing/subscription*' => Http::response([
                'has_subscription' => true,
                'subscription' => [
                    'id' => 1,
                    'status' => 'active',
                    'user_id' => 1,
                    'is_annual' => false,
                    'component' => 'talk',
                    'resource_id' => null,
                    'monthly_price' => 2.23,
                    'name' => 'Premium',
                    'name_readable' => 'Premium'
                ]
            ])
        ]);

        $subscription = Billing::getSubscription(1);

        expect($subscription->id)->toBe(1);
        expect($subscription->status)->toBe(SubscriptionStatus::ACTIVE);
        expect($subscription->user_id)->toBe(1);
        expect($subscription->is_annual)->toBeFalse();
        expect($subscription->component)->toBe(ComponentType::TALK);
        expect($subscription->resource_id)->toBeNull();
        expect($subscription->monthly_price)->toBe(2.23);
        expect($subscription->name)->toBe('Premium');
        expect($subscription->name_readable)->toBe('Premium');

    });

});