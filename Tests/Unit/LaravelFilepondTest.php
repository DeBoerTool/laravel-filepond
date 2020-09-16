<?php

use Dbt\LaravelFilepond\LaravelFilepond;
use Dbt\LaravelFilepond\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LaravelFilepondTest extends TestCase
{
    /** @test */
    public function check_if_file_exists()
    {
        Storage::fake($this->config['disk_name']);
        
        $file = UploadedFile::fake()->image('avatar.jpg');

        $locationId = app(LaravelFilepond::class)->store($file);

        $this->assertTrue(app(LaravelFilepond::class)->exists($locationId));
    }
}
