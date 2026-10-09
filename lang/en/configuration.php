<?php

/**
 * Playground
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Configuration Language Lines
    |--------------------------------------------------------------------------
    |
    |
    */

    'keywords.required' => 'Ignoring a keyword [INVALID: :keyword] for the composer.json file.',
    'translations.invalid' => 'Ignoring an invalid translation under [language: :language] in [section: :section] for [key: :key => :message].',
    'translations.section.invalid' => 'Ignoring an invalid [section: :section] for [:language] translations.',
    'require.required' => 'Ignoring a requirement: package [INVALID: :package] with version [:version] for the composer.json file.',
    'require.version.required' => 'Ignoring a requirement: package [:package] with version [INVALID: :version] for the composer.json file.',
    'require-dev.required' => 'Ignoring a dev requirement: package [INVALID: :package] with version [:version] for the composer.json file.',
    'require-dev.version.required' => 'Ignoring a dev requirement: package [:package] with version [INVALID: :version] for the composer.json file.',

    'seeders.configs.slug.required' => 'Ignoring a slug [INVALID: :slug] for the seeder data files.',
    'seeders.className.required' => 'Ignoring a className [INVALID: :slug] for the seeder generator files.',

    'addRoute.slug.required' => 'A route slug is required when specifying a route file [:file] to load in the service provider.',

];
