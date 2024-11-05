## About Laravel GeoNames

This project was created by, and is maintained by [Brian Faust](https://github.com/faustbrian), and is a Laravel Eloquent package designed for interacting with GeoNames datasets. Be sure to browse through the [changelog](CHANGELOG.md), [code of conduct](.github/CODE_OF_CONDUCT.md), [contribution guidelines](.github/CONTRIBUTING.md), [license](LICENSE), and [security policy](.github/SECURITY.md).

## Installation

> **Note**
> This package requires [PHP](https://www.php.net/) 8.2 or later, and it supports [Laravel](https://laravel.com/) 10 or later.

To get the latest version, simply require the project using [Composer](https://getcomposer.org/):

```bash
$ composer require faustbrian/laravel-geonames
```

You can publish the migrations by using:

```bash
$ php artisan vendor:publish --tag="laravel-geonames-migrations"
```

You can publish the configuration file by using:

```bash
$ php artisan vendor:publish --tag="laravel-geonames-config"
```

## Usage

Please review the contents of [our test suite](/tests) for detailed usage examples.

## Credits

This package incorporates elements from [nevadskiy/laravel-geonames](https://github.com/nevadskiy/laravel-geonames). However, modifications have been made to ensure compatibility with this package's database structure. Additionally, support for various other data types has been added.
