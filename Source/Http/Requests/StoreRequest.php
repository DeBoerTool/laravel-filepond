<?php

namespace Dbt\LaravelFilepond\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            config('laravel-filepond.field') => config('laravel-filepond.temporary_file_rules', ['required', 'file', 'max:12288'])
        ];
    }
}
