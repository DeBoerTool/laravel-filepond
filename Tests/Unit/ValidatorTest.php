<?php

use Dbt\LaravelFilepond\Filepond;
use Dbt\LaravelFilepond\LaravelFilepondRule;
use Dbt\LaravelFilepond\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ValidatorTest extends TestCase
{
    public static function filepondProvider()
    {
        $testFileSize = 53480 / 1024;
        return [
          ['file', false],
          ['image', false],
          ['min:2', false],
          ['max:500', false],
          ['mimes:png', false],
          ['mimetypes:image/png', false],
          ['size:' . $testFileSize ,  false],
        ];
    }

    /**
     * @test
     * @dataProvider filepondProvider
     */
    public function passes_for_filepond_files($rule, $fails, $message = null)
    {
        $testFilePath = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'Capture.PNG';

        $disk = Storage::fake($this->config['disk_name']);

        $file = new UploadedFile($testFilePath, 'Capture.PNG');

        $locationId = app(Filepond::class)->store($file);

        $validator = Validator::make([
            'file' => $locationId
        ], [
            'file' => $rule
        ]);

        $this->assertEquals($fails, $validator->fails());

        if ($fails) {
            $this->assertEquals([$message], $validator->getMessageBag()->all());
        }
    }
}
