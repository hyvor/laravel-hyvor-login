<?php

namespace Hyvor\Internal\Tests\Unit\PHPStan;

use Hyvor\Internal\PHPStan\LicenseIntAndBoolOnlyRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<LicenseIntAndBoolOnlyRule>
 */
class LicenseIntAndBoolOnlyRuleTest extends RuleTestCase
{

    protected function getRule(): Rule
    {
        return new LicenseIntAndBoolOnlyRule();
    }

    public function testRule(): void
    {

        $this->analyse([__DIR__ . '/data/license-int-and-bool-fail.php'], [
            [
                'License property $myBadLimit should be int or bool', // asserted error message
                8, // asserted error line
            ],
        ]);

    }

}
