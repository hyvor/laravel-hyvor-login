<?php

namespace Hyvor\Internal\Billing\Feature\Bag;

class TalkFeatureBag extends FeatureBag
{

    public function __construct(
        public ?int $websites,
        public int $max_upload_size_mb,
        public int $memberships_fee,
        public bool $sso,
        public bool $no_branding,
        public bool $custom_email_domain,
        public bool $webhooks,
    )
    {
    }


}