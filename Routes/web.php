<?php

use Illuminate\Support\Facades\Route;
use Dbt\LaravelFilepond\Http\Controllers\FilepondController;

Route::post('/filepond/process', [FilepondController::class, 'store']);
Route::delete('/filepond/revert', [FilepondController::class, 'revert']);
