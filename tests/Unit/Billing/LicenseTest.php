<?php

namespace Hyvor\Internal\Tests\Unit\Billing;

use Hyvor\Internal\Billing\Billing;
use Hyvor\Internal\Billing\Plan\BlogsPlans;
use Hyvor\Internal\InternalApi\ComponentType;
use Hyvor\Internal\Tests\TestCase;
use Illuminate\Support\Facades\Http;

class LicenseTest extends TestCase
{

    public function testNoSubscriptions(): void
    {

        Http::fake([
            'https://hyvor.com/api/internal/billing/subscription*' => Http::response([
                'subscription' => null,
            ])
        ]);

        $billing = new Billing();
        $subscription = $billing->license(ComponentType::TALK, 1);
        $this->assertNull($subscription);

    }

    public function testWithBlogsSubscription(): void
    {

        Http::fake([
            'https://hyvor.com/api/internal/billing/subscription*' => Http::response([
                'subscription' => [
                    'monthly_price' => 10.00,
                    'annual_price' => 100.00,
                    'is_annual' => false,
                    'plan' => 'starter',
                    'features' => [
                        'users' => 1,
                        'storageGb' => 5,
                        'analyses' => true,
                        'noBranding' => true,
                        'integrationHyvorTalk' => true,
                    ]
                ]
            ])
        ]);

        $subscription = Billing::getSubscriptionOfUser(ComponentType::BLOGS, 1);
        assert($subscription !== null);

        $this->assertEquals(10.00, $subscription->monthlyPrice);
        $this->assertEquals(100.00, $subscription->annualPrice);
        $this->assertFalse($subscription->isAnnual);
        $this->assertEquals(BlogsPlans::STARTER, $subscription->plan);
        $this->assertEquals(1, $subscription->features->users);
        $this->assertEquals(5, $subscription->features->storageGb);
        $this->assertTrue($subscription->features->analyses);
        $this->assertTrue($subscription->features->noBranding);
        $this->assertTrue($subscription->features->integrationHyvorTalk);

    }

}
