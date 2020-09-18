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
     * Set a validation rules for temporary files
     * Example: ['file', 'mimes:png,jpg']
     */
    'temporary_file_rules' => ['required', 'file', 'max:12288'],

    /**
     * Name of field under file will be posted to server for process request
     */
    'field' => env('FILEPOND_FIELD', 'filepond'),

    /**
     * This suffix will be used for meta files
     */
    'meta_file_suffix' => '.metadata',

    /**
     * Middleware for filepond routes. It can be string or an array
     */
    'middleware' => 'web'
];

```

By default, the laravel filepond will store its temporary files on Laravel's local disk. If you want a dedicated disk you should add a disk to config/filesystems.php. This would be a typical configuration:
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

### Configure filepond
To upload the file from your form to the endpoints provided by laravel filepond package, You have to set following filepond configurations

```js
 FilePond.setOptions({
    server: {
        process: '/filepond/process',
        revert: '/filepond/revert',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf
        },
    }
})
```

Once file uploaded to successfully to the server, filepond store the unique id of the file in the hidden input field.

### Accessing the files
You can access uploaded files in the controller just like accessing regular http uploaded files. You just have to use `Dbt\LaravelFilepond\Request` instead of `Illuminate\Http\Request`

```php
use Dbt\LaravelFilepond\Request;

public function __invoke(Request $request)
{
    $request->file('avatar')->store('avatars');
}

```

### Validate request

When you post the form to the server, You might want to validate your form request. Validating the files uploaded by filepond is exactly same as validating http uploaded files.

```php

use Dbt\LaravelFilepond\Request;

public function __invoke(Request $request)
{
    $request->validate([
        'avatar' => ['required', 'file', 'image', 'min:2', 'max:500']
    ]);

    $request->file('avatar')->store('avatars');
}
```

Laravel filepond checks the unique file ID of your file in request and replace the field with uploaded file during validation.


## Etc.

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
