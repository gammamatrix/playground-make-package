# {{ package_name }}
{{ package_workflow }}
The {{ package_name }} package.

## Installation

You can install the package via composer:

```shell
composer require {{ packagist }}
```

## Configuration

All options are disabled by default.

See the contents of the published config file: [config/{{ package }}.php](config/{{ package }}.php)

You can publish the config file with:
```shell
php artisan vendor:publish --provider="{{ namespace }}\ServiceProvider" --tag="playground-config"
```

## Cloc

```shell
composer cloc
```

```terminaloutput
➜  {{ package }} git:(develop) ✗ composer cloc
```

## PHPStan

Tests at level 9 on:
{{readme_phpstan}}

```shell
composer analyse
```

## Coding Standards

```shell
composer format
```

## Testing

Run unit tests:
```shell
composer test
```

Run unit and feature tests:
```shell
composer test-dev
```

Run unit and feature tests in parallel:
```shell
composer test-parallel
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

{{readme_license}}
