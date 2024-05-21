# Playground: Make Package

[![Playground CI Workflow](https://github.com/gammamatrix/playground-make-package/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-make-package/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-make-package/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The Playground Make Package Tool for building out [Laravel](https://laravel.com/docs/11.x) applications.

## Installation

**NOTE:** This is a development tool and not meant for normal installations.

## `artisan about`

Playground Make provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-make-package.png" alt="screenshot of artisan about command with Playground Make."> -->

## Configuration

You can publish the config file with:
```bash
php artisan vendor:publish --provider="Playground\Make\ServiceProvider" --tag="playground-config"
```

See the contents of the published config file: [config/playground-make-package.php](config/playground-make-package.php)

## Commands

This application utilizes Laravel make commands.

### Build out skeletons

These examples use [Playground Matrix](https://github.com/gammamatrix/playground-matrix/) models and controllers:

#### Build: Playground Model

Create the model package skeleton:

```sh
artisan playground:make:package Matrix --license MIT --namespace Playground/Matrix --package playground-matrix --module Matrix --packagist gammamatrix/playground-matrix --type playground-model --package-version 73.0.0 --email support@example.com --playground --factories --migrations --models --test --skeleton --force
```

```sh
artisan playground:make:package Matrix --license MIT --namespace Playground/Matrix --package playground-matrix --module Matrix --packagist gammamatrix/playground-matrix --type playground-model --package-version 73.0.0 --email jeremy.postlethwaite@gmail.com --playground --factories --migrations --models --test --skeleton --force --covers
```


Build the models out for the package:

```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix.json --force
```

#### Build: Playground Api

Create the API package skeleton:

```sh
artisan playground:make:package "Matrix API" --license MIT --namespace Playground/Matrix/Api --package playground-matrix-api --module Matrix --packagist gammamatrix/playground-matrix-api --type playground-api --package-version 73.0.0 --email support@example.com --playground --api --controllers --policies --requests --routes --swagger --test --skeleton --force
```

Pass the models into the API package and build:

```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix.json --force --build --api
```

Build the out the controllers, policies, requests, resources, routes, Swagger Documentation, and tests:

```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix-api.json --force
```

#### Build: Playground Resource

```sh
artisan playground:make:package "Matrix Resource" --license MIT --namespace Playground/Matrix/Resource --package playground-matrix-resource --module Matrix --packagist gammamatrix/playground-matrix-resource --type playground-resource --package-version 73.0.0 --email support@example.com --playground --resource --controllers --blade --policies --requests --routes --swagger --test --skeleton --force
```

Pass the models into the Resource package and build:

```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix.json --force --build --resource
```

Build the out the Blade templates, controllers, policies, requests, resources, routes, Swagger Documentation, and tests:

```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix-resource.json --force
```

```sh
artisan playground:make:package "Matrix Resource" --license MIT --namespace Playground/Matrix/Resource --package playground-matrix-resource --module Matrix --packagist gammamatrix/playground-matrix-resource --type playground-resource --package-version 73.0.0 --email support@example.com --playground --resource --controllers --blade --policies --requests --routes --swagger --test --skeleton --force --model-package resources/configurations/playground-matrix/package.playground-matrix-resource.json
```

**TODO:** working
- [x] needs abilities in config
- [x] needs routes in config
- [x] needs policies in config
- [x] needs required attribute (title) in requests
- [ ] Views: also need clean up
- [ ] needs About Command Test
- [ ] Unit tests: Requests
- [ ] Unit tests: Policies

```sh
artisan playground:make:package "Matrix Resource" --license MIT --namespace Playground/Matrix/Resource --package playground-matrix-resource --module Matrix --packagist gammamatrix/playground-matrix-resource --type playground-resource --package-version 73.0.0 --email support@example.com --playground --resource --controllers --blade --policies --requests --routes --swagger --test --skeleton --force --model-package resources/configurations/playground-matrix/package.playground-matrix.json --build
```

With --covers
```sh
artisan playground:make:package "Matrix Resource" --license MIT --namespace Playground/Matrix/Resource --package playground-matrix-resource --module Matrix --packagist gammamatrix/playground-matrix-resource --type playground-resource --package-version 73.0.0 --email support@example.com --playground --resource --controllers --blade --policies --requests --routes --swagger --test --force --model-package resources/configurations/playground-matrix/package.playground-matrix.json --build --covers --skeleton
```


## PHPStan

Tests at level 9 on:
- `config/`
- `lang/`
- `src/`
- `tests/Feature/`

```sh
composer analyse
```

## Coding Standards

```sh
composer format
```

## Testing

```sh
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Jeremy Postlethwaite](https://github.com/gammamatrix)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
