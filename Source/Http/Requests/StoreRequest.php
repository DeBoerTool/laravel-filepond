<?php

namespace Dbt\LaravelFilepond\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            config('laravel-filepond.field') => 'required'
        ];
    }
}
