<?php

return [

    /**
     * Disk on which to store temporary files
     */
    'disk_name' => env('FILEPOND_TEMP_DISK', 'local'),

    /**
     * Set a validation rules for temporary files
     * Example: ['file', 'mimes:png,jpg']
     */
    'temporary_file_rules' => ['required', 'file', 'max:12288'],

    /**
     * Name of field under file will be posted to server for process request
     */
    'field' => env('FILEPOND_FIELD', 'filepond'),

    /**
     * This suffix will be used for meta files
     */
    'meta_file_suffix' => '.metadata',

    /**
     * Middleware for filepond routes. It can be string or an array
     */
    'middleware' => 'web'
];
