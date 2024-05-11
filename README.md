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



```sh
artisan playground:make:package Matrix --license MIT --namespace Playground/Matrix --package playground-matrix --module Matrix --packagist gammamatrix/playground-matrix --type playground-model --package-version 73.0.0 --email support@example.com --playground --factories --migrations --models --test --skeleton --force
```

```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix.json --force
```

#### Build: Playground Api


```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix.json --force --build --api
```


```sh
artisan playground:make:package Matrix --license MIT --namespace Playground/Matrix/Api --package playground-matrix-api --module Matrix --type playground-api --package-version 73.0.0 --playground --api --controllers --policies --requests --routes --swagger --test --skeleton --force
```

```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix.json --force
```



```sh
artisan playground:make:package "Matrix Resource" --license MIT --namespace Playground/Matrix/Api --package playground-matrix-api --module Matrix --type playground-api --playground --controllers --policies --requests --routes --test --skeleton --force
```

#### Build: Playground Resource

```sh
artisan playground:make:package Matrix --license MIT --namespace Playground/Matrix/Resource --package playground-matrix-resource --module Matrix --type playground-resource --package-version 73.0.0 --playground --resource --controllers --policies --requests --routes --swagger --test --skeleton --force
```

```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix.json --force --build --api
```



```sh
artisan playground:make:package --file resources/configurations/playground-matrix/package.playground-matrix.json --force --build --resource --skeleton
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
