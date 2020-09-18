<?php

namespace Dbt\LaravelFilepond;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Validator as BaseValidator;

class Validator extends BaseValidator
{
    /** @var Filepond */
    private $filePond;

    public function __construct($translator, $data, $rules, $messages, $customAttributes, Filepond $filePond)
    {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);

        $this->filePond = $filePond;

        $this->convertFilepondAttributes();
    }

    private function convertFilepondAttributes(): void
    {
        $data = $this->getData();

        foreach ($data as $attribute => $value) {
            $data[$attribute] = $this->hasRule($attribute, $this->fileRules)
                ? $this->getFile($value)
                : $value;
        }

        $this->setData($data);
    }

    private function getFile($value): ?UploadedFile
    {
        if ($value instanceof UploadedFile) {
            return $value;
        }

        if (is_string($value) && $this->filePond->exists($value)) {
            return $this->filePond->get($value);
        }

        return null;
    }
}
