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
                    aiTokensK: 0,
                    autoTranslationsCharsK: 0,
                    talkCreditsK: 0,
                    postEmailsK: 0,
                    analyses: false,
                    noBranding: false,
                )
            );

            $this->plan(
                'growth',
                19,
                new BlogsLicense(
                    users: 5,
                    storageGb: 40,
                    aiTokensK: 100,
                    autoTranslationsCharsK: 100,
                    talkCreditsK: 100,
                    postEmailsK: 25,
                    analyses: true,
                    noBranding: true,
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
                    aiTokensK: 0,
                    autoTranslationsCharsK: 0,
                    talkCreditsK: 0,
                    postEmailsK: 0,
                    analyses: false,
                    noBranding: false,
                )
            );

            $this->plan(
                'growth',
                40,
                new BlogsLicense(
                    users: 10,
                    storageGb: 100,
                    aiTokensK: 100,
                    autoTranslationsCharsK: 100,
                    talkCreditsK: 100,
                    postEmailsK: 25,
                    analyses: true,
                    noBranding: true,
                )
            );

            $this->plan(
                'premium',
                125,
                new BlogsLicense(
                    users: 50,
                    storageGb: 500,
                    aiTokensK: 1000,
                    autoTranslationsCharsK: 500,
                    talkCreditsK: 250,
                    postEmailsK: 100,
                    analyses: true,
                    noBranding: true,
                )
            );

        });


    }
}
