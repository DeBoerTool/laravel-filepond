<?php

namespace Dbt\LaravelFilepond;

use Illuminate\Http\UploadedFile as BaseUploadedFile;

class UploadedFile extends BaseUploadedFile
{
    public function isValid()
    {
        /**
         * Local files are used with Filepond, We should not enforce HTTP file upload
         */
        return UPLOAD_ERR_OK === $this->getError();
    }
}
