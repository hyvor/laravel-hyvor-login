<?php

namespace Hyvor\Internal\Billing\License;

/**
 * How the license was derived.
 */
enum DerivedFrom
{

    // custom resource license (usually for agencies)
    case CUSTOM_RESOURCE;
    // custom user license. Enterprise and agency
    case CUSTOM_USER;
    // usual SAAS subscription
    case SUBSCRIPTION;
    // trial license
    case TRIAL;

}
