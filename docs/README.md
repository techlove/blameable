# Eloquent Blameable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-appkit/blameable.svg?style=flat-square)](https://packagist.org/packages/laravel-appkit/blameable)
[![Build Status](https://img.shields.io/github/workflow/status/laravel-appkit/blameable/Automated%20Tests?style=flat-square)](https://github.com/laravel-appkit/blameable/actions?query=workflow%3A%22Automated+Tests%22)
[![Quality Score](https://img.shields.io/github/workflow/status/laravel-appkit/blameable/Check%20&%20fix%20styling?label=code%20quality&style=flat-square)](https://github.com/laravel-appkit/blameable/actions?query=workflow%3A%22Check+%26+fix+styling%22)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-appkit/blameable.svg?style=flat-square)](https://packagist.org/packages/laravel-appkit/blameable)
[![Licence](https://img.shields.io/packagist/l/laravel-appkit/blameable.svg?style=flat-square)](https://packagist.org/packages/laravel-appkit/blameable)

This package allows you to store the creator (`created_by`) and last editor (`edited_by`) of an Eloquent Model. You can also store the user who soft deleted a model.

## Installation

You can install the package via composer:

```bash
composer require laravel-appkit/blameable
```

## Usage

First, add the `created_at`, `updated_at` (and optionally `deleted_at`) columns to your table. This can be done via the `blameable` method in your migration.

```php
Schema::create('articles', function (Blueprint $table) {
    $table->increments('id');
    $table->string('title');
    $table->text('body');
    $table->timestamps();

    // add this line to create the columns
    $table->blameable(); // pass in true as the first argument to enable soft deletes columns
});
```

Next, add the `AppKit\Blameable\Traits\Blameable` trait to the model

``` php
namespace App\Models;

use AppKit\Blameable\Traits\Blameable;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use Blameable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'body'
    ];
}
```

The id of the user can be accessed via the `created_at`, `updated_at` and `deleted_at` attributes on the model.

Relationships have also been setup to fetch an instance of the user model

```php
$article = Article::first();

$article->creator // the user model that created the article
$article->editor // the user model that last updated the article
$article->deleter // the user model that soft deleted the article
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email appkit-security@coutts.io instead of using the issue tracker.

Please see [SECURITY](.github/SECURITY.md) for more details.

## Credits

- [Darren Coutts](https://github.com/laravel-appkit)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
