<?php

namespace Dbt\LaravelFilepond\Http\Controllers;

use Dbt\LaravelFilepond\Http\Requests\StoreRequest;
use Dbt\LaravelFilepond\LaravelFilepond;

class FilepondController extends Controller
{
    /** @var LaravelFilepond */
    protected $filePond;

    public function __construct(LaravelFilepond $filePond)
    {
        $this->filePond = $filePond;
    }

    public function store(StoreRequest $request)
    {
        $file = $request->file(config('laravel-filepond.field'));

        $file = is_array($file) ? $file[0] : $file;

        $locationId = $this->filePond->store($file);

        return response($locationId)->header('Content-Type', 'text/plain');
    }
}
