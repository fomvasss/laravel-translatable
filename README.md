# Make translations for Eloquent models

[![License](https://img.shields.io/packagist/l/fomvasss/laravel-translatable.svg?style=for-the-badge)](https://packagist.org/packages/fomvasss/laravel-translatable)
[![Build Status](https://img.shields.io/github/stars/fomvasss/laravel-translatable.svg?style=for-the-badge)](https://github.com/fomvasss/laravel-translatable)
[![Latest Stable Version](https://img.shields.io/packagist/v/fomvasss/laravel-translatable.svg?style=for-the-badge)](https://packagist.org/packages/fomvasss/laravel-translatable)
[![Total Downloads](https://img.shields.io/packagist/dt/fomvasss/laravel-translatable.svg?style=for-the-badge)](https://packagist.org/packages/fomvasss/laravel-translatable)
[![Quality Score](https://img.shields.io/scrutinizer/g/fomvasss/laravel-translatable.svg?style=for-the-badge)](https://scrutinizer-ci.com/g/fomvasss/laravel-translatable)

This is a Laravel package for creating translations content of Eloquent-models. For translation, created models in different languages, between which relations is established through additional fields. The main advantage is that there is no need to create additional tables, models or specific JSON-fields, all operations occur without changes.
The functionality is very easy to integrate into an existing / running project. All you need to do is add two fields to the desired table / model by connecting one PHP-Trait.

----------

## Installation

To install the package, in terminal:

```bash
composer require fomvasss/laravel-translatable
```

### Publish

Run in terminal:

```bash
php artisan vendor:publish --provider="Fomvasss\LaravelTranslatable\ServiceProvider"
```

A configuration file will be published to `config/translatable.php`.

### Usage

1. Add columns (`langcode` & `translation_uuid` in translatable DB-table:

Example:

```
Schema::create('articles', function (Blueprint $table) {
    ...
    $table->translatable();
});

// To drop columns
Schema::table('articles', function (Blueprint $table) {
    $table->dropTranslatable();
});
```

2. Your model should use `Fomvasss\LaravelTranslatable\Traits\HasTranslations` trait to enable translations:

Example: `app/Models/Article.php`

```php

use Fomvasss\LaravelTranslatable\Traits\HasTranslations;

class Article extends Model
{
    use HasTranslations;
    //...
}
```

3. Get and Save article translations in your controller:

Example controller: `app/Http/Controllers/ArticleController.php`

```php
class ArticleController extends Controller 
{
    public function index(Request $request)
    {
        // Select by config('app.locale'):
        $articles = \App\Model\Article::byLang()->paginate();
        // OR by request
        $articles = \App\Model\Article::byLang($request->lang)->paginate();
        // ...
    }
    
    public function store(Request $request)
    {
    	// Let's create an article in English (en)
        $article1 = \App\Model\Article::create([
            'name' => 'Article 1, for EN language',
            'langcode' => 'en',
        ]);
        
        // For the saved article ($article1)  will be auto-generated UUID
        // Example: 70cf3963-cf41-464c-9d81-411d3a524789

        // We will create a translation into Ukrainian (uk) for the article ($article1)
        $article2 = \App\Model\Article::create([
            'name' => 'Стаття 1, для UK мови',
            'langcode' => 'uk',
            'translation_uuid' => $article1->uuid,
        ]);
        // OR
        $article2 = \App\Model\Article::create(['name' => 'Стаття 1, для UK мови']);
        $article2->saveTranslatable('uk', $article1->uuid);
  
        // A couple langcode & translation_uuid must be unique
        // ...
    }

    public function show($id)
    {
        $article = \App\Model\Article::findOrFail($id);
        
        // Get related translations list for article 
        $translation = $article->getTranslationList();
        
        return view('stow', compact('article', 'translation'));
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email fomvasss@gmail.com instead of using the issue tracker.

## Credits

- [Fomin Vasyl](https://github.com/fomvasss)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

**Happy coding**!