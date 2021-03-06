<?php

namespace Dbt\LaravelFilepond\LaravelFilepond\Tests;

use Dbt\LaravelFilepond\Filepond;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Dbt\LaravelFilepond\Tests\TestCase;

class RevertFileTest extends TestCase
{
    /** @test */
    public function remove_file()
    {
        $this->withoutExceptionHandling();

        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        Storage::fake($this->config['disk_name']);

        $locationId = app(Filepond::class)->store($uploadedFile);

        $this->assertTrue(app(Filepond::class)->exists($locationId));

        $response = $this->call('DELETE', 'filepond/revert', [], [], [], [], $locationId);

        $response->assertStatus(200);

        $this->assertFalse(app(Filepond::class)->exists($locationId));
    }
}
