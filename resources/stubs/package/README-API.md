# {{ package_name }}
{{ package_workflow }}
The {{ package_name }} package.

## Documentation

### Swagger

This application provides Swagger documentation: [swagger.json](swagger.json).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

Swagger API Documentation is built with npm.
- npm is only needed to generate documentation and is not needed to operate the CMS API.

See [package.json](package.json) requirements.

Install npm.

```sh
npm install
```

Build the documentation to generate the [swagger.json](swagger.json) configuration.

```sh
npm run docs
```

Documentation
- Preview [swagger.json on the Swagger Editor UI.](https://editor.swagger.io/?url=https://raw.githubusercontent.com/{{packagist}}/develop/swagger.json)
- Preview [swagger.json on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/{{packagist}}/develop/swagger.json)

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

Tests at level 9 on:
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