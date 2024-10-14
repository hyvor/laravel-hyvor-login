<?php

namespace Hyvor\Internal\Billing;

enum SubscriptionStatus : string
{

    case PENDING = 'pending';
    case ACTIVE = 'active';
    case PAST_DUE = 'past_due';
    case CANCELED = 'canceled';

}