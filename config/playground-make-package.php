<?php

/**
 * Playground
 */

declare(strict_types=1);

/**
 * Playground Make Package Configuration and Environment Variables
 *
 * @return array{
 *       about: bool,
 *       locale: ?string,
 *       load: array{commands: bool, translations: bool}
 *   }
 */
return [

    /*
    |--------------------------------------------------------------------------
    | About Information
    |--------------------------------------------------------------------------
    |
    | By default, information will be displayed about this package when using:
    |
    | `artisan about`
    |
    */

    'about' => (bool) env('PLAYGROUND_MAKE_PACKAGE_ABOUT', true),

    'locale' => env('PLAYGROUND_MAKE_PACKAGE_LOCALE'),

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    |
    | By default, commands and translations are loaded.
    |
    */

    'load' => [
        'commands' => (bool) env('PLAYGROUND_MAKE_PACKAGE_LOAD_COMMANDS', true),
        'translations' => (bool) env('PLAYGROUND_MAKE_PACKAGE_LOAD_TRANSLATIONS', true),
    ],
];
