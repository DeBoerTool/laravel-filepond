<?php

use Illuminate\Support\Facades\Route;
use Dbt\LaravelFilepond\Http\Controllers\FilepondController;

Route::middleware(config('laravel-filepond.middleware', []))
    ->prefix(config('laravel-filepond.route_prefix', 'filepond'))
    ->group(function () {
        Route::post('process', [FilepondController::class, 'store']);
        Route::delete('revert', [FilepondController::class, 'revert']);
    });
