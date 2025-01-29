<?php

return [

    /**
     * This is the domain that the app is running on.
     * Routes are only accessible from this domain.
     * @todo: refactor this into `route.` setting
     */
    'domain' => env('APP_DOMAIN', '{any}'),

    /**
     * Instance URL
     * Where is the core component running?
     */
    'instance' => env('HYVOR_INSTANCE', 'https://hyvor.com'),

    /**
     * Private instance URL
     * To communicate in a private network
     */
    'private_instance' => env('HYVOR_PRIVATE_INSTANCE'),

    /**
     * Whether to fake auth and billing
     * Only possible in the local environment
     */
    'fake' => env('HYVOR_FAKE', false),

    /**
     * Which component is this?
     * See `src/InternalApi/ComponentType.php` for available components
     *
     * core - hyvor.com
     * talk - talk.hyvor.com
     * ..
     */
    'component' => 'core',

    'auth' => [

        /**
         * Whether to add auth routes
         */
        'routes' => true,

        /**
         * If routes is true, set the domain restriction
         * By default, added to all domains
         */
        'routes_domain' => '{any}',

        /**
         * Hyvor Login settings
         */
        'hyvor' => [
            /**
             * @deprecated
             * HYVOR Public URL
             * Users are redirected to this URL to login/signup
             */
            'url' => env('AUTH_HYVOR_URL', 'https://hyvor.com'),

            /**
             * HYVOR Private URL (for internal API calls)
             * This is only required if you have HYVOR running on a private network
             * ex: http://0.0.0.1
             */
            'private_url' => env('AUTH_HYVOR_PRIVATE_URL'),
        ],

    ],

    'i18n' => [

        /**
         * Folder that contains the locale JSON files
         */
        'folder' => base_path('locales'),

        /**
         * Default locale
         */
        'default' => 'en-US',

    ],

    /**
     * Deprecated don't use
     */
    'media' => [

        'path' => 'api/media',

        'disk' => 'public'

    ]

];
