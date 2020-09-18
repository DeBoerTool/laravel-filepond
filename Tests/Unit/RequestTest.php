<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Dbt\LaravelFilepond\Request as LaravelFilepondRequest;
use Dbt\LaravelFilepond\Filepond;
use Dbt\LaravelFilepond\Tests\TestCase;
use Illuminate\Http\UploadedFile;

class RequestTest extends TestCase
{
    /** @test */
    public function get_single_processed_file_in_submit_request()
    {
        Storage::fake($this->config['disk_name']);

        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        $locationId = app(Filepond::class)->store($uploadedFile);

        $request = LaravelFilepondRequest::create('testing/submit', 'POST', [
            $this->config['field'] => $locationId
        ]);

        $this->assertInstanceOf(UploadedFile::class, $request->file('filepond'));

        $this->assertSame('avatar.jpg', $request->file('filepond')->getClientOriginalName());

        $this->assertSame('image/jpeg', $request->file('filepond')->getMimeType());

        $this->assertSame($uploadedFile->getSize(), $request->file('filepond')->getSize());
    }

    /** @test */
    public function get_multiple_processed_files_in_submit_request()
    {
        Storage::fake($this->config['disk_name']);

        $uploadedFileA = UploadedFile::fake()->image('avatar.jpg');

        $uploadedFileB = UploadedFile::fake()->image('avatar2.jpg');

        $locationIdA = app(Filepond::class)->store($uploadedFileA);

        $locationIdB = app(Filepond::class)->store($uploadedFileB);


        $request = LaravelFilepondRequest::create('testing/submit', 'POST', [
            $this->config['field'] => [$locationIdA, $locationIdB]
        ]);

        $this->assertInstanceOf(Collection::class, $request->file('filepond'));

        $this->assertSame('avatar.jpg', $request->file('filepond')->first()->getClientOriginalName());

        $this->assertSame('image/jpeg', $request->file('filepond')->first()->getMimeType());

        $this->assertSame($uploadedFileA->getSize(), $request->file('filepond')->first()->getSize());

        $this->assertSame('avatar2.jpg', $request->file('filepond')->last()->getClientOriginalName());

        $this->assertSame('image/jpeg', $request->file('filepond')->last()->getMimeType());

        $this->assertSame($uploadedFileB->getSize(), $request->file('filepond')->last()->getSize());
    }

    /** @test */
    public function return_uploaded_file_if_request_have_one()
    {
        $uploadedFile = UploadedFile::fake()->image('avatar.jpg');

        $request = LaravelFilepondRequest::create('testing/submit', 'POST', [], [], [
            'filepond' => $uploadedFile
        ]);

        $this->assertInstanceOf(UploadedFile::class, $request->file('filepond'));

        $this->assertSame('avatar.jpg', $request->file('filepond')->getClientOriginalName());

        $this->assertSame('image/jpeg', $request->file('filepond')->getMimeType());

        $this->assertSame($uploadedFile->getSize(), $request->file('filepond')->getSize());
    }
}
