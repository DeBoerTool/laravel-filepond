<?php

namespace Dbt\LaravelFilepond;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dbt\LaravelFilepond\LaravelFilepond\Skeleton\SkeletonClass
 */
class LaravelFilepondFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-filepond';
    }
}
