<?php
/**
 * Playground
 */

declare(strict_types=1);

/**
 * Playground Make Configuration and Environment Variables
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

    'about' => (bool) env('PLAYGROUND_MAKE_ABOUT', true),

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    |
    | By default, commands and translations are loaded.
    |
    */

    'load' => [
        'commands' => (bool) env('PLAYGROUND_MAKE_LOAD_COMMANDS', true),
        'translations' => (bool) env('PLAYGROUND_MAKE_LOAD_TRANSLATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Paths
    |--------------------------------------------------------------------------
    |
    | By default, makes will be loaded from the resources directory of this
    | package. A different path may be provided with:
    |
    | PLAYGROUND_MAKE_PATHS_MAKES
    |
    */

    'paths' => [
        'makes' => env('PLAYGROUND_MAKE_PATHS_MAKES', ''),
        // 'makes' => env('PLAYGROUND_MAKE_PATHS_MAKES', '/tmp/does-not-exist'),
        // 'makes' => env('PLAYGROUND_MAKE_PATHS_MAKES', '/tmp'),

    ],
];
