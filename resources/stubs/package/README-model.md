# {{ package_name }}
{{ package_workflow }}
The {{ organization }} {{ module }} is a package for [Laravel](https://laravel.com/docs/12.x) applications.

{{ package_description }}

Read more on using [{{ package_name }} at Read the Docs](https://gammamatrix-playground.readthedocs.io/en/develop/components/{{ module_slug }}.html)

## Installation

**NOTE:** This package is required by:
- [{{ package_name }} API](https://github.com/gammamatrix/{{ package }}-api): API without UI
- [{{ package_name }} Resource](https://github.com/gammamatrix/{{ package }}-resource): API with UI

Install this package, with composer, to get access to the {{ module }} Models:

```bash
composer require {{ packagist }}
```

## `artisan:about`

{{ organization }} {{ module }} provides information in the `artisan about` command.

<img src="resources/docs/artisan-about-{{ package }}.png" alt="screenshot of artisan about command with {{ package_name }}.">

## Configuration

Migrations are disabled by default. This package may sometimes be installed where another system handles the migrations.

See the contents of the published config file: [config/{{ package }}.php](config/{{ package }}.php)

You can publish the config file with:
```bash
php artisan vendor:publish --provider="{{ namespace }}\ServiceProvider" --tag="playground-config"
```

### Environment Variables

| env()                                | config()                         | Default |
|--------------------------------------|----------------------------------|---------|
| `{{ config_space }}_ABOUT`           | `{{ package }}.about`           | `true`  |
| `{{ config_space }}_LOAD_MIGRATIONS` | `{{ package }}.load.migrations` | `false` |
- The loading option for migrations does not take effect if the migrations have been exported to your app. The control for loading is handled in the package [ServiceProvider.](src/ServiceProvider.php)

## Models

This package includes [factories](database/factories), models and [migrations](database/migrations) for:{{ readme_models }}

## Migrations

All migrations are disabled by default.

See the contents of the published config file: [database/migrations](database/migrations)
- NOTE: There are {{ readme_models_count }} tables that will be created, they do have indexes and unique constraints defined; however, this release does not have the foreign key constraint migrations included at this time.

You can publish the migrations file with:
```bash
php artisan vendor:publish --provider="{{ namespace }}\ServiceProvider" --tag="playground-migrations"
```

## Cloc

```sh
composer cloc
```

```
➜  {{ package }} git:(develop) ✗ composer cloc
> cloc --exclude-dir=node_modules,output,vendor .
       0 text files.
       0 unique files.
       0 files ignored.

github.com/AlDanial/cloc v 1.98  T=0.0 s (0.0 files/s, 0.0 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                             0              0              0              0
PHP                              0              0              0              0
YAML                             0              0              0              0
XML                              0              0              0              0
Markdown                         0              0              0              0
INI                              0              0              0              0
-------------------------------------------------------------------------------
SUM:                             0              0              0              0
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 10 on:
{{readme_phpstan}}

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Testing

Unit tests
```sh
composer test
```

Unit and feature tests
```sh
composer test-dev
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jeremy Postlethwaite](https://github.com/gammamatrix)
{{readme_license}}
