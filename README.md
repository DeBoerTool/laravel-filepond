# Laravel Filepond

This package provides Laravel backend implementation of filepond.

## Requirements
This LaravelFilepond package requires PHP 7.2+ and Laravel 5.8+

## Installation

LaravelFilepond can be installed via composer

```bash
composer require dbt/laravel-filepond
```
This package will automatically register a service provider.

You can optionally publish the config file
```bash
php artisan vendor:publish --provider="Dbt\LaravelFilepond\LaravelFilepondServiceProvider" --tag="config"
```
This is the default content of the file

```php
<?php

return [

    /**
     * Disk on which to store temporary files
     */
    'disk_name' => env('FILEPOND_TEMP_DISK', 'local'),

    /**
     * Name of field under file will be posted to server for process request
     */
    'field' => env('FILEPOND_FIELD', 'filepond'),

    /**
     * This suffix will be used for meta files
     */
    'meta_file_suffix' => '.metadata'
];

```

By default, the laravel filepont will store its temporary files on Laravel's local disk. If you want a dedicated disk you should add a disk to config/filesystems.php. This would be a typical configuration:
```php
    // ...
    'disks' => [
        // ...
         'temp' => [
            'driver' => 'local',
            'root' => storage_path('temp'),
        ],
    // ...
```
Don't forget to ignore the directory of your configured disk so the files won't end up in your git repo.

## Basic Usage
Coming soon.

## Etc.

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
