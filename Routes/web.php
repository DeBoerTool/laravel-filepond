<?php

use Illuminate\Support\Facades\Route;
use Dbt\LaravelFilepond\Http\Controllers\FilepondController;

Route::post('process', [FilepondController::class, 'store']);
Route::delete('revert', [FilepondController::class, 'revert']);
