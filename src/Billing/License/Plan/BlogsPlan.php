<?php

namespace Hyvor\Internal\Billing\License\Plan;

use Hyvor\Internal\Billing\License\BlogsLicense;

class BlogsPlan extends PlanAbstract
{

    const int GB = 10 ** 9;

    public function config(): void
    {

        // Version 1
        $this->version(1, function () {

            $this->plan(
                'starter',
                9,
                new BlogsLicense(
                    users: 2,
                    storage: 1 * self::GB,
                    aiTokens: 0,
                    autoTranslationsChars: 0,
                    talkCredits: 0,
                    postEmails: 0,
                    analyses: false,
                    noBranding: false,
                )
            );

            $this->plan(
                'growth',
                19,
                new BlogsLicense(
                    users: 5,
                    storage: 40 * self::GB,
                    aiTokens: 100_000,
                    autoTranslationsChars: 100_000,
                    talkCredits: 100_000,
                    postEmails: 25_000,
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
                    storage: 2 * self::GB,
                    aiTokens: 0,
                    autoTranslationsChars: 0,
                    talkCredits: 0,
                    postEmails: 0,
                    analyses: false,
                    noBranding: false,
                )
            );

            $this->plan(
                'growth',
                40,
                new BlogsLicense(
                    users: 10,
                    storage: 100 * self::GB,
                    aiTokens: 100_000,
                    autoTranslationsChars: 100_000,
                    talkCredits: 100_000,
                    postEmails: 25_000,
                    analyses: true,
                    noBranding: true,
                )
            );

            $this->plan(
                'premium',
                125,
                new BlogsLicense(
                    users: 50,
                    storage: 500 * self::GB,
                    aiTokens: 1_000_000,
                    autoTranslationsChars: 500_000,
                    talkCredits: 250_000,
                    postEmails: 100_000,
                    analyses: true,
                    noBranding: true,
                )
            );

        });


    }
}
