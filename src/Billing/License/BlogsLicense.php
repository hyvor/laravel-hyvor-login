<?php

namespace Hyvor\Internal\Billing\License;

class BlogsLicense extends License
{

    public function __construct(

        /**
         * Number of blog users (team members) allowed.
         */
        public int $users = 2,

        /**
         * Storage in GB. Used when storing media files.
         */
        public int $storageGb = 1,

        /**
         * GPT Tokens per month in thousands.
         */
        public int $aiTokensK = 1,

        /**
         * DeepL characters per month in thousands.
         */
        public int $autoTranslationsCharsK = 1,

        /**
         * Hyvor Talk credits per month in thousands.
         */
        public int $talkCreditsK = 0,

        /**
         * Hyvor Post Emails per month in thousands.
         */
        public int $postEmailsK = 0,

        /**
         * Link and SEO analyses.
         */
        public bool $analyses = true, // SEO and link analysis

        /**
         * Whether to disable branding by default.
         */
        public bool $noBranding = false,
    )
    {
    }

}
