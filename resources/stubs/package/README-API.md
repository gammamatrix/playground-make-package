# {{ package_name }}
{{ package_workflow }}
The {{ package_name }} package.

## Documentation

### OpenAPI

This application provides OpenAPI documentation: [openapi.json](openapi.json).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

OpenAPI API Documentation is built with npm using Redocly.
- npm is only needed to generate documentation and is not needed to operate the {{ package_name }} API.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [openapi.json](openapi.json) configuration.

```sh
npm run docs
```

Documentation
- Preview [openapi.json on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/{{packagist}}/develop/openapi.json)

## Installation

You can install the package via composer:

```bash
composer require {{ packagist }}
```

## Configuration

All options are disabled by default.

See the contents of the published config file: [config/{{ package }}.php](config/{{ package }}.php)

You can publish the config file with:
```bash
php artisan vendor:publish --provider="{{ namespace }}\ServiceProvider" --tag="playground-config"
```

## Cloc

```sh
composer cloc
```

```
➜  {{ package }} git:(develop) ✗ composer cloc
> cloc --exclude-dir=node_modules,output,vendor .
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

```sh
composer test --parallel
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
{{readme_license}}
