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
- npm is only needed to generate documentation and is not needed to operate the Playground: Matrix API.

See [package.json](package.json) requirements.

Install npm.

```shell
npm install
```

Build the documentation to generate the [openapi.yaml](openapi.yaml) configuration.

```shell
npm run docs
```

Documentation
- Preview [openapi.yaml on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/develop/openapi.yaml)

## Installation

You can install the package via composer:

```shell
composer require gammamatrix/playground-matrix-api
```

## `artisan about`

Playground provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-matrix-api.png" alt="screenshot of artisan about command with Playground: Matrix API."> -->

## Configuration

You can publish the config file with:

```shell
php artisan vendor:publish --provider="Playground\Matrix\Api\ServiceProvider" --tag="playground-config"
```

All routes are enabled by default. They may be disabled via environment variable or the configuration.

See the contents of the published config file: [config/playground-matrix-api.php](config/playground-matrix-api.php)

You can publish the routes file with:
```shell
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

```shell
composer cloc
```

```terminaloutput
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                           493              0              0          40573
YAML                           164              4              0          37497
PHP                            473           4379           5875          20635
XML                              3              0              7            215
Markdown                         3             54              1            110
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                          1137           4440           5883          99042
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 10 on:
- `config/`
- `routes/`
- `src/`
- `tests/Feature/`
- `tests/Unit/`

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

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
