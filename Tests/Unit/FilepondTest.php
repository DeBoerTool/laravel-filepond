<?php

use Dbt\LaravelFilepond\Filepond;
use Dbt\LaravelFilepond\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FilepondTest extends TestCase
{
    /** @test */
    public function check_if_file_exists()
    {
        Storage::fake($this->config['disk_name']);

        $file = UploadedFile::fake()->image('avatar.jpg');

        $locationId = app(Filepond::class)->store($file);

        $this->assertTrue(app(Filepond::class)->exists($locationId));
    }
}
