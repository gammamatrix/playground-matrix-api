# Playground Matrix Api

[![Playground CI Workflow](https://github.com/gammamatrix/playground-matrix-api/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9 src and tests](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The `playground-matrix-api` Laravel package.

This package provides an API for interacting with the [Playground Matrix](https://github.com/gammamatrix/playground-matrix), a project management and task system.

If you need a UI, then use [Playground Matrix Resource](https://github.com/gammamatrix/playground-matrix-resource), which provides a Blade UI.

## Documentation

Read more on using [Playground Matrix API at Read the Docs: Playground Documentation.](https://gammamatrix-playground.readthedocs.io/en/develop/components/matrix.html)

### Postman

A postman collection is provided in the repository: [postman-playground-matrix-api.json.](postman-playground-matrix-api.json)
- This same collection is viewable on the [Postman: GammaMatrix Playground workspace.](https://www.postman.com/gammamatrix/workspace/playground/collection/1185343-d8d03c95-fca9-4edc-8ec1-4a1a3546b4b5)

### Swagger

This application provides Swagger documentation: [swagger.json](swagger.json).
- The endpoint models support locks, trash with force delete, restoring, revisions and more.
- Index endpoints support advanced query filtering.

Swagger API Documentation is built with npm.
- npm is only needed to generate documentation and is not needed to operate the MATRIX API.

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
- Preview [swagger.json on the Swagger Editor UI.](https://editor.swagger.io/?url=https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/develop/swagger.json)
- Preview [swagger.json on the Redocly Editor UI.](https://redocly.github.io/redoc/?url=https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/develop/swagger.json)

## Installation

You can install the package via composer:

```bash
composer require gammamatrix/playground-matrix-api
```

## `artisan about`

Playground provides information in the `artisan about` command.

<!-- <img src="resources/docs/artisan-about-playground-matrix-api.png" alt="screenshot of artisan about command with Playground Matrix Api."> -->

## Configuration

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Playground\Matrix\Api\ServiceProvider" --tag="playground-config"
```

All routes are enabled by default. They may be disabled via enviroment variable or the configuration.

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
➜  playground-matrix-api git:(feature/GH-3) ✗ composer cloc
> cloc --exclude-dir=node_modules,output,vendor .
     657 text files.
     637 unique files.
      21 files ignored.

github.com/AlDanial/cloc v 1.98  T=0.83 s (769.0 files/s, 124350.4 lines/s)
-------------------------------------------------------------------------------
Language                     files          blank        comment           code
-------------------------------------------------------------------------------
JSON                             6              0              0          56264
PHP                            462           3480           5704          20678
YAML                           162              5              0          16472
XML                              3              0              7            215
Markdown                         3             52              1            118
INI                              1              3              0             12
-------------------------------------------------------------------------------
SUM:                           637           3540           5712          93759
-------------------------------------------------------------------------------
```

## PHPStan

Tests at level 9 on:
- `config/`
- `database/`
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

## Tests

```sh
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
