# lang2csv

Imports and exports laravel localisations to and from csv files.

#Installation

##Composer

To install this package using composer, run: `composer require matt-cannon/lang2csv:*`

#Configuring

Open `config/app.php` and add `MattCannon\Lang2Csv\Providers\LanguageExportServiceProvider::class` to the service providers list

#Usage

To export a csv, go to the console and type:

```bash
php artisan lang:export en #replace 'en' with the base translation folder you would like to use.
```

this will place a csv file in the resources/lang directory.

Once the strings in this csv have been translated, you can import this as a new language directory by typing:

```bash
php artisan lang:import filename.csv es #replace 'es' with the two letter code for the destination language
```

This should generate a directory for the language code, and files with nested arrays for all of the translations provided.

