<?php

namespace Hyvor\Internal\Billing\FeatureBag;

class BlogsFeatureBag extends FeatureBag
{

    public function __construct(
        public int $users = 1,
        public int $storageGb = 2,
        // SEO and link analysis
        public bool $analyses = false,
        public bool $noBranding = false,
        public int $integrationHyvorTalkCreditsMillion = 1,
    )
    {
    }


}