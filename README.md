# Playground Matrix Api

[![Playground CI Workflow](https://github.com/gammamatrix/playground-matrix-api/actions/workflows/ci.yml/badge.svg?branch=develop)](https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/testing/develop/testdox.txt)
[![Test Coverage](https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/testing/develop/coverage.svg)](tests)
[![PHPStan Level 9 src and tests](https://img.shields.io/badge/PHPStan-level%209-brightgreen)](.github/workflows/ci.yml#L120)

The `playground-matrix-api` Laravel package.

This package provides an API for interacting with the [Playground Matrix](https://github.com/gammamatrix/playground-matrix), a project management and task system.

If you need a UI, then use [Playground Matrix Resource](https://github.com/gammamatrix/playground-matrix-resource), which provides a Blade UI.

This application provides Swagger documentation: [swagger.json](swagger.json).
- See the [Playground Matrix Api swagger.json on the Swagger Editor.](https://editor.swagger.io/?url=https://raw.githubusercontent.com/gammamatrix/playground-matrix-api/develop/swagger.json)
- The endpoint models support locks, trash with force delete, restoring and more.
- Index endpoints support advanced query filtering.

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
