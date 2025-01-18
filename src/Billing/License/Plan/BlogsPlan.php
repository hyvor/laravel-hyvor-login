<?php

namespace Hyvor\Internal\Billing\License\Plan;

use Hyvor\Internal\Billing\License\BlogsLicense;

class BlogsPlan extends PlanAbstract
{

    public function config(): void
    {

        // Version 1
        $this->version(1, function () {

            $this->plan(
                'starter',
                9,
                new BlogsLicense(
                    users: 2,
                    storageGb: 1,
                    analyses: false,
                    noBranding: false,
                    integrationHyvorTalkCreditsK: null,
                )
            );

            $this->plan(
                'growth',
                19,
                new BlogsLicense(
                    users: 5,
                    storageGb: 40,
                    analyses: true,
                    noBranding: true,
                    integrationHyvorTalkCreditsK: 100,
                )
            );

        });

        // Version 2: 2025-01
        $this->version(2, function () {

            $this->plan(
                'starter',
                12,
                new BlogsLicense(
                    users: 2,
                    storageGb: 2,
                    analyses: false,
                    noBranding: false,
                    integrationHyvorTalkCreditsK: null,
                )
            );

            $this->plan(
                'growth',
                40,
                new BlogsLicense(
                    users: 10,
                    storageGb: 100,
                    analyses: true,
                    noBranding: true,
                    integrationHyvorTalkCreditsK: 100,
                )
            );

            $this->plan(
                'premium',
                125,
                new BlogsLicense(
                    users: 50,
                    storageGb: 500,
                    analyses: true,
                    noBranding: true,
                    integrationHyvorTalkCreditsK: 500,
                )
            );

        });


    }
}