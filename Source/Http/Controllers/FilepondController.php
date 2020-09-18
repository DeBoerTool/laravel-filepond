<?php

namespace Dbt\LaravelFilepond\Http\Controllers;

use Dbt\LaravelFilepond\Http\Requests\StoreRequest;
use Dbt\LaravelFilepond\FilepondFacade;
use Illuminate\Http\Request;

class FilepondController extends Controller
{
    public function store(StoreRequest $request)
    {
        $file = $request->file(config('laravel-filepond.field'));

        $file = is_array($file) ? $file[0] : $file;

        $locationId = FilepondFacade::store($file);

        return response($locationId)->header('Content-Type', 'text/plain');
    }

    public function revert(Request $request)
    {
        $locationId = $request->getContent();

        FilepondFacade::delete($locationId);
    }
}
