<?php

namespace Hyvor\Internal\Billing\License;

/**
 * How the license was derived.
 */
enum DerivedFrom: string
{

    // custom resource license (usually for agencies)
    case CUSTOM_RESOURCE = 'custom_resource';
    // custom user license. Enterprise and agency
    case CUSTOM_USER = 'custom_user';
    // usual SAAS subscription
    case SUBSCRIPTION = 'subscription';
    // trial license
    case TRIAL = 'trial';

}
