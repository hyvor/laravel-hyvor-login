<?php

namespace Hyvor\Internal\Billing\License;

class BlogsLicense extends License
{

    public function __construct(
        public int $users = 1,
        public int $storageGb = 2,
        public bool $analyses = false, // SEO and link analysis
        public bool $noBranding = false,
        public ?int $integrationHyvorTalkCreditsK = null,
    )
    {
    }

}