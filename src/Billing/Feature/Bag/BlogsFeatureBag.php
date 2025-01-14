<?php

namespace Hyvor\Internal\Billing\Feature\Bag;

class BlogsFeatureBag extends FeatureBag
{

    public function __construct(
        public int $users,
        public int $storageGb,
        // SEO and link analysis
        public bool $analyses,
        public bool $noBranding,
        public bool $integrationHyvorTalk,
    )
    {
    }


}