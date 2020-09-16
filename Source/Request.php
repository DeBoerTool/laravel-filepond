<?php

namespace Dbt\LaravelFilepond;

use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
{
    public function rules(): array
    {
        return [];
    }
    
    public function file($key = null, $default = null)
    {
        if ($files = parent::file($key, $default)) {
            return $files;
        }

        $locationIds = (array) $this->input($key);
        
        $results = [];
        
        $filepond = app(LaravelFilepond::class);

        foreach ($locationIds as $serverId) {
            $results[] = $filepond->get($serverId);
        }

        return count($results) > 1 ? collect($results) : $results[0];
    }
}
