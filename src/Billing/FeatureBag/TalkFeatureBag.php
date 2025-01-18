<?php

namespace Hyvor\Internal\Billing\FeatureBag;

class TalkFeatureBag extends FeatureBag
{

    public function __construct(
        public ?int $websites = 1,
        public int $max_upload_size_mb = 2,
        public int $memberships_fee = 3,
        public bool $sso = false,
        public bool $no_branding = false,
        public bool $custom_email_domain = false,
        public bool $webhooks = false,
    )
    {
    }


}