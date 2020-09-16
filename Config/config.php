<?php

return [

    /**
     * Disk on which to store temporary files
     */
    'disk_name' => env('FILEPOND_TEMP_DISK', 'local'),

    /**
     * Name of field under file will be posted to server for process request
     */
    'field' => env('FILEPOND_FIELD', 'filepond'),

    /**
     * This suffix will be used for meta files
     */
    'meta_file_suffix' => '.metadata'
];
