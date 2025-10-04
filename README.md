# Playground: Matrix API

[![Playground CI Workflow](https://github.com/gammamatrix/playground-matrix-api/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/testing/develop/coverage.svg)](tests)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-level%2010-brightgreen)](.github/workflows/ci.yml#L128)

Playground: Matrix API

This package provides an API without UI for interacting with the [Playground: Matrix](https://github.com/gammamatrix/playground-matrix), a model package for Laravel.

If you need a JSON API with a UI, then have a look at [Playground: Matrix Resource.](https://github.com/gammamatrix/playground-matrix-resource)

## Documentation

Read more on using [Playground: Matrix API at Read the Docs: Playground Documentation](https://gammamatrix-playground.readthedocs.io/en/develop/built-components/matrix.html)

### Postman

A postman collection is provided in the repository: [postman-playground-matrix-api.json.](postman-playground-matrix-api.json)
- This same collection is viewable on the [Postman: GammaMatrix Playground Workspace.](https://www.postman.com/gammamatrix/workspace/playground/documentation/1185343-1e4a5656-d4e0-45b2-8f4e-daad7a6ee2b1)

### OpenAPI

This application provides OpenAPI documentation: [openapi.yaml](openapi.yaml).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

OpenAPI API Documentation is built with npm using Redocly.
- npm is only needed to generate documentation and is not needed to operate the Playground: Matrix API API.

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
- Preview [openapi.yaml on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/develop/openapi.yaml)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-matrix-api
```

## `artisan about`

Playground provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-matrix-api.png" alt="screenshot of artisan about command with Playground: Matrix API."> -->

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Playground\Matrix\Api\ServiceProvider" --tag="playground-config"
```

All routes are enabled by default. They may be disabled via environment variable or the configuration.

See the contents of the published config file: [config/playground-matrix-api.php](config/playground-matrix-api.php)

You can publish the routes file with:
```bash
php artisan vendor:publish --provider="Playground\Matrix\Api\ServiceProvider" --tag="playground-routes"
```
- The routes while be published in a folder at `routes/playground-matrix-api`

### Environment Variables

If you are unable or do not want to publish [configuration files for this package](config/playground-matrix-api.php),
you may override the options via system environment variables.

Information on [environment variables is available on the wiki for this package](https://github.com/gammamatrix/playground-matrix-api/wiki/Environment-Variables)

## Migrations

This package requires the migrations in [playground-matrix](https://github.com/gammamatrix/playground-matrix) a Laravel package.

## Cloc

```sh
composer cloc
```

```
➜  playground-matrix-api git:(develop) ✗ composer cloc
    1141 text files.
    1120 unique files.
     249 files ignored.

github.com/AlDanial/cloc v 2.06  T=0.33 s (3396.8 files/s, 335144.1 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                           481              0              0          42797
YAML                           164              5              0          37527
PHP                            461           4303           5637          19462
XML                             10              0              7            568
Markdown                         3             55              1            126
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                          1120           4366           5645         100492
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 10 on:
- `config/`
- `routes/`
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

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
