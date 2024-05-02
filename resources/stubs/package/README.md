# {{ package_name }}

The {{ package_name }} package.

## Installation

You can install the package via composer:

```bash
composer require {{ packagist }}
```

## Configuration

All options are disabled by default.

See the contents of the published config file: [config/{{ package }}.php](.config/{{ package }}.php)

You can publish the config file with:
```bash
php artisan vendor:publish --provider={{ namespace }}\ServiceProvider" --tag="playground-config"
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
