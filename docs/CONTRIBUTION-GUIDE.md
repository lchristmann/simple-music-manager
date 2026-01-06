# Contribution Guide

The Simple Music Manager is open to contributions

- you can open issues in GitHub and
- pose pull requests (fork the repository first)

## Editing the Diagrams

Edit them easily with [draw.io](https://www.drawio.com/).

## Adding another Language

At the time of writing, the there's two languages available: English and German.<br>
The technical admin can set the default language via the `APP_LOCALE` environment variable, and users can switch between all available ones using the language switch in the header bar.

If you want to add another language (which I’d be happy to see), follow these steps.

### 1. Add the Laravel language files

> Laravel itself only ships with English translations.<br>
> To add another language, you must install the language files.

Choose a locale from the [list of available locales](https://laravel-lang.com/available-locales-list.html) of the `laravel-lang/lang` package.<br>
Then run:

```shell
php artisan lang:add <locale>
```

This installs framework-level translations such as validation messages, dates, and pagination.

### 2. Register the locale in the language switch

The language must be explicitly enabled in the Filament language switch.

Add the new locale code to the `locales()` list in the [AppServiceProvider.php](../app/Providers/AppServiceProvider.php):

````php
LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
    $switch->locales(['en', 'de', '<locale>']);
});
````

Only locales listed here will be selectable by users.

### 3. (Not necessary) Filament translations

Filament already includes translations for many languages internally.

E.g. for German I had no reason to overwrite those, but if you don't like some Filament text translations,
feel free to run the following and edit the PHP arrays in the `/lang/vendor/filament-panels/<locale>`.

```shell
php artisan vendor:publish --tag=filament-panels-translations
```

> This spawns folders for all locales, but please only include the edited one with your language in the pull request.

### 4. Add application-specific translations

All custom application strings live in the JSON translation files `lang/<locale>.json`.

To add a new language, you can simply copy all application-specific translations below the blank line e.g. from `lang/de.json` into your new language file and translate the values.

The English text is always used as the key (don't touch that - just replace the values!).

### 5. Verify

Run the application (see [Developer Docs](../DEVELOPER-DOCS.md)), switch to the new language via the language selector, and confirm that everything looks correct.
