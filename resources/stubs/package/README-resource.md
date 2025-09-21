# {{ package_name }}
{{ package_workflow }}
{{ package_name }}

This package provides an API and a Blade UI for interacting with the [{{ model_package_name }}](https://github.com/gammamatrix/{{ model_package }}), a model package for Laravel.

If you need a JSON API without a UI, then have a look at [{{ model_package_name }} API.](https://github.com/gammamatrix/{{ model_package }}-api)

## Documentation

Read more on using [{{ docs_name }}]({{ docs_url }})

### Postman

A postman collection is provided in the repository: [postman-{{ package }}.json.](postman-{{ package }}.json)
- This same collection is viewable on the [{{ postman_collection }}.]({{ postman_url }})

### OpenAPI

This application provides OpenAPI documentation: [openapi.yaml](openapi.yaml).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

OpenAPI API Documentation is built with npm using Redocly.
- npm is only needed to generate documentation and is not needed to operate the {{ package_name }} API.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [openapi.yaml](openapi.yaml) configuration.

```sh
npm run docs
```

Documentation
- Preview [openapi.yaml on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/{{packagist}}/develop/openapi.yaml)

## Installation

You can install the package via composer:

```bash
composer require {{ packagist }}
```

## `artisan about`

Playground provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-{{ package }}.png" alt="screenshot of artisan about command with {{ package_name }}."> -->

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="{{ namespace }}\ServiceProvider" --tag="playground-config"
```

All routes are enabled by default. They may be disabled via enviroment variable or the configuration.

See the contents of the published config file: [config/{{ package }}.php](config/{{ package }}.php)

You can publish the routes file with:
```bash
php artisan vendor:publish --provider="{{ namespace }}\ServiceProvider" --tag="playground-routes"
```
- The routes while be published in a folder at `routes/{{ package }}`

### Environment Variables

If you are unable or do not want to publish [configuration files for this package](config/{{ package }}.php),
you may override the options via system environment variables.

Information on [environment variables is available on the wiki for this package](https://github.com/gammamatrix/{{ package }}/wiki/Environment-Variables)

## Migrations

This package requires the migrations in [{{ model_package }}](https://github.com/gammamatrix/{{ model_package }}) a Laravel package.

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

Run unit tests:
```sh
composer test
```

Run unit and feature tests:
```sh
composer test-dev
```

Run unit and feature tests in parallel:
```sh
composer test-parallel
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
{{readme_license}}
