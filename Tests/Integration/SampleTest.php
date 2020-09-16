<?php

namespace Dbt\LaravelProject\Tests\Integration;

class SampleTest extends IntegrationTestCase
{
    /** @test */
    public function booting_the_framework (): void
    {
        $this->assertTrue($this->app->isBooted());
    }
}
