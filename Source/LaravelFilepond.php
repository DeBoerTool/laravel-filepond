<?php

namespace Dbt\LaravelFilepond;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LaravelFilepond
{
    /** @var string */
    private $diskName;

    /** @var string */
    private $metaFileSuffix;

    /** @var \Illuminate\Contracts\Filesystem\Filesystem */
    private $disk;

    public function __construct()
    {
        $this->diskName = config('laravel-filepond.disk_name');

        $this->disk = Storage::disk($this->diskName);

        $this->metaFileSuffix = config('laravel-filepond.meta_file_suffix');
    }

    /**
     * Store temporary uploaded file
     */
    public function store(UploadedFile $file): string
    {
        if (! $this->storeMeta($file)) {
            throw new Exception('Unable to store meta file.');
        }

        $locationId = $file->store('/', ['disk' => $this->diskName]);

        if (!$locationId) {
            throw new Exception('Unable to store file.');
        }

        return $locationId;
    }

    /**
     * Check if uploaded file exists
     */
    public function exists($locationId): bool
    {
        $disk = Storage::disk($this->diskName);

        $metaDataFileName = $this->getMetaFileName($locationId);

        return $disk->exists($locationId) && $disk->exists($metaDataFileName);
    }

    /**
     * Delete uploaded file and its meta
     */
    public function delete(string $locationId): bool
    {
        return $this->disk->delete([
            $locationId,
            $this->getMetaFileName($locationId)
        ]);
    }

    /**
     * Get Uploaded file
     */
    public function get(string $locationId): UploadedFile
    {
        if (! $this->exists($locationId)) {
            throw new Exception('File does not exists.');
        }

        $metaData = $this->getMeta($locationId);

        return new UploadedFile(
            $this->disk->getAdapter()->applyPathPrefix($locationId),
            $metaData['original_name'],
            $metaData['mime_type'],
            $metaData['error']
        );
    }

    /**
     * Get meta of the given location
     */
    private function getMeta($locationId) : array
    {
        return json_decode($this->disk->get($this->getMetaFileName($locationId)), true);
    }

    /**
     * Store meta of uploaded file
     */
    private function storeMeta(UploadedFile $file): bool
    {
        $filename = $this->getMetaFileName($file->hashName());

        $meta = [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'error' => $file->getError(),
        ];

        return $this->disk->put($filename, json_encode($meta));
    }

    /**
     * Generate meta file name
     */
    private function getMetaFileName(string $file): string
    {
        return  $file . $this->metaFileSuffix;
    }
}
