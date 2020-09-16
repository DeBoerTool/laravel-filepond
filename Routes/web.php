<?php

use Illuminate\Support\Facades\Route;
use Dbt\LaravelFilepond\Http\Controllers\FilepondController;

Route::post('/filepond/process', [FilepondController::class, 'store']);
