<?php

namespace Dbt\LaravelFilepond\Tests;

use Dbt\LaravelFilepond\LaravelFilepondServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /** @var Repository */
    protected $config;

    public function setUp(): void
    {
        parent::setUp();
        $this->config = config('laravel-filepond');
    }

    protected function getPackageProviders($app)
    {
        return [LaravelFilepondServiceProvider::class];
    }
}
