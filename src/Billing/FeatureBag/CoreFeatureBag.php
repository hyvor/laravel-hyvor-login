<?php

namespace Hyvor\Internal\Billing\FeatureBag;

/**
 * Core features = Enterprise features
 */
class CoreFeatureBag extends FeatureBag
{

    public function __construct(
        public ?TalkFeatureBag  $talk = null,
        public ?BlogsFeatureBag $blogs = null,
    )
    {
    }

}