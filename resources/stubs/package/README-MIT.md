# {{ package_name }}
{{ package_workflow }}
The {{ package_name }} package.

## Installation

You can install the package via composer:

```bash
composer require {{ packagist }}
```

## Configuration

All options are disabled by default.

See the contents of the published config file: [config/{{ package }}.php](config/{{ package }}.php)

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
- `config/`
- `database/`
- `src/`
- `tests/Feature/`
- `tests/Unit/`

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


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
