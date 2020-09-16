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

    public function __construct()
    {
        $this->diskName = config('laravel-filepond.disk_name');

        $this->metaFileSuffix = config('laravel-filepond.meta_file_suffix');
    }

    /**
     * Store temporary uploaded file
     */
    public function store(UploadedFile $file)
    {
        $this->storeMeta($file);

        return $file->store('/', ['disk' => $this->diskName]);
    }

    public function get(string $locationId)
    {
        $disk = Storage::disk($this->diskName);

        $metaDataFileName = $this->getMetaFileName($locationId);

        if (! $disk->exists($locationId) || ! $disk->exists($metaDataFileName)) {
            throw new Exception('File does not exists.');
        }

        $metaData = json_decode($disk->get($metaDataFileName), true);

        return new UploadedFile(
            $disk->getAdapter()->applyPathPrefix($locationId),
            $metaData['original_name'],
            $metaData['mime_type'],
            $metaData['error']
        );
    }

    private function storeMeta(UploadedFile $file)
    {
        $filename = $this->getMetaFileName($file->hashName());

        $meta = [
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'error' => $file->getError(),
        ];

        Storage::disk($this->diskName)->put($filename, json_encode($meta));
    }

    private function getMetaFileName(string $file)
    {
        return  $file . $this->metaFileSuffix;
    }
}
