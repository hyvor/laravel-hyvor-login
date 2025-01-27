<?php

namespace Hyvor\Internal\Tests\Unit\Billing;

use Hyvor\Internal\Billing\Billing;

describe('new subscription', function() {

    it('validates float', function() {
       expect(fn() => Billing::newSubscription(
           null,
           'Account',
           2.234,
           false,
           'Premium',
              'Premium'
       ))->toThrow(
           \InvalidArgumentException::class,
           'Monthly price can have up to 2 decimal points'
       );
    });

});