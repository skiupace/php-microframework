# php-microframework

A minimal, dependency-light PHP microframework skeleton. This repository provides a tiny core (Container, App, Router, Database, Validator, Session, etc.), a simple bootstrap that wires a Database binding into the container, a place for route definitions, and folders for HTTP abstractions, views and tests.

## Table of contents

- [Project structure](#project-structure)
- [Requirements](#requirements)
- [Installation](#installation)
- [Bootstrapping](#bootstrapping)
- [App container API](#app-container-api)
- [Accessing the Database](#accessing-the-database)
- [Routes and Router](#routes-and-router)
- [Configuration](#configuration)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)
- [Where to look in the code](#where-to-look-in-the-code)

## Project structure

Top-level files and folders in the repository:

- .gitignore
- Core/ — core framework classes (App, Container, Database, Router, Validator, Session, Response, Authenticator, exceptions, helpers)
  - Core/App.php
  - Core/Container.php
  - Core/Database.php
  - Core/Router.php
  - Core/Validator.php
  - Core/Session.php
  - Core/Response.php
  - Core/Authenticator.php
  - Core/ValidationException.php
  - Core/functions.php
  - Core/Middleware/ (middleware hooks)
- Http/ — HTTP layer (request/response helpers, middleware, adapters)
- bootstrap.php — bootstraps the Container and binds Database into it
- composer.json
- config.php — returns an array with the configuration for db and api keys (do not push into prod)
- public/ — document root / front controller (not populated in the repo root)
- routes.php — application route declarations
- tests/ — test cases
- views/ — templates

## Requirements

- PHP 8.0+ (check composer.json for any platform constraints)
- Composer for autoloading and installing dependencies
- Typical PHP extensions (json, mbstring, etc.)

## Installation

Clone the repository and install dependencies:

```bash
git clone https://github.com/skiupace/php-microframework.git && \
cd php-microframework && \
composer install
```

## Bootstrapping

The repository includes bootstrap.php which creates a Container, binds the Core\Database implementation using the `database` key from config.php, and registers the container with Core\App.

Current bootstrap.php contents:

```php
<?php

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();

$container->bind(Database::class, function () {
  $config = require base_path('config.php');
  return new Database($config['database']);
});

App::setContainer($container);
```

Notes:

- bootstrap.php expects a helper function `base_path()` to resolve the project root (see Core/functions.php).
- `config.php` must return a PHP array and include at least a top-level `database` key that is passed to Core\Database.

## App container API

Core/App exposes a minimal static API for working with the application container:

- App::setContainer(Container $container): void
- App::container(): Container
- App::bind(string $key, callable $resolver): void
- App::resolve(string $key): mixed

These methods delegate to the underlying Container implementation (Core/Container.php). The bootstrap uses this API to provide the Database binding to the app.

Example: resolving a binding

```php
$db = App::resolve(Core\Database::class);
```

## Accessing the Database

The bootstrap binds Core\Database::class to a resolver that constructs the Database from the `database` config. After bootstrap, resolve the Database from the container anywhere in application code:

```php
/** @var \Core\Database $db */
$db = App::resolve(\Core\Database::class);
```

Adjust usage based on the public methods exposed by Core\Database (see Core/Database.php for implementation details).

## Routes & Router

- routes.php is the location to declare your application routes.
- Core/Router.php implements the router logic; inspect that file to learn the supported route patterns, parameter extraction, and dispatch behavior.

Place route definitions in routes.php and ensure your front controller requires it after bootstrapping.

## Configuration

config.php should return an associative array. bootstrap.php expects the following structure at minimum:

```php
<?php
return [
    'database' => [
        // keys expected by Core\Database (driver, dsn, host, user, pass, etc.)
    ],
    // other configuration keys...
];
```

Edit config.php to match the connection options required by Core\Database.

## Testing

write you tests in /tests/Unit for single unit tests, or in /tests/Feature for feature tests, then run tests with:

```bash
./vendor/bin/pest
```

Or you can run:

```bash
composer test
```

## Contributing

- Open an issue to discuss larger changes.
- Fork the repository and create a feature branch for pull requests.
- Include tests and documentation for new behavior.

## License

This project is licensed under the MIT License. See the included [LICENSE](./LICENSE) file for full terms and copyright information.

## Where to look in the code

- Core/App.php: static container API (setContainer, container, bind, resolve)
- Core/Container.php: container implementation (bind/resolve)
- Core/Database.php: database adapter used by bootstrap
- Core/Router.php: router implementation
- Core/functions.php: helper functions (e.g., base_path)
- Core/Middleware/: middleware hooks for the core
- Http/: HTTP layer (request/response, middleware adapters)
- routes.php: to define your application routes
- bootstrap.php: actual bootstrap code that wires Database into the container
