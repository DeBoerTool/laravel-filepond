<?php

namespace Dbt\LaravelFilepond\LaravelFilepond\Tests;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Dbt\LaravelFilepond\Tests\TestCase;

class ProcessFileTest extends TestCase
{
    /** @test */
    public function process_the_file()
    {
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        Storage::fake($this->config['disk_name']);

        $response = $this->postJson('/filepond/process', [
            $this->config['field'] => $uploadedFile
        ]);

        $response->assertStatus(200);

        $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');

        $this->assertEquals($uploadedFile->hashName(), $response->getContent());

        Storage::disk($this->config['disk_name'])->assertExists($uploadedFile->hashName());

        Storage::disk($this->config['disk_name'])->assertExists($uploadedFile->hashName() . $this->config['meta_file_suffix']);
    }

    /** @test */
    public function field_is_required()
    {
        Storage::fake($this->config['disk_name']);

        $response = $this->postJson('/filepond/process');
    
        $response->assertStatus(422);

        $response->assertJsonValidationErrors([$this->config['field'] => 'required']);
    }

    /** @test */
    public function field_must_be_file()
    {
        Storage::fake($this->config['disk_name']);

        $response = $this->postJson('/filepond/process', [
            $this->config['field'] => 'string'
        ]);
    
        $response->assertStatus(422);

        $response->assertJsonValidationErrors([$this->config['field'] => 'file']);
    }
}
