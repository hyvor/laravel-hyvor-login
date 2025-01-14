<?php

namespace Hyvor\Internal\Billing\Feature\Bag;

class CoreFeatureBag extends FeatureBag
{

    public function __construct(
        public ?TalkFeatureBag  $talk = null,
        public ?BlogsFeatureBag $blogs = null,
    )
    {
    }

}