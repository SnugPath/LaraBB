# LaraBB

## Requirements

- PHP >= 8.1
- Any relational Database (preferably MariaDB)
- Node.js >= 16
- Docker (optional, for development)

## Setup

- Clone the repository
- Run `npm install`
- Run `composer install`
- Run migrations with `php artisan migrate`

For the development environment, after installing required packages with composer, you can run:
```
./vendor/bin/sail up
```
Now, you can run the migrations and all artisan commands using Sail.

You'll need docker for this to work.

## Contributions
To contribute, you can do the following:
- Fork the repository
- Clone your fork
- Commit your changes
- Do a pull request against the repository

## Tests
```
php artisan test
```
if you are using sail, you can also run
```
./vendor/bin/sail artisan test
```
