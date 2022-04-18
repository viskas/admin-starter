<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

/**
 * Class UploadService
 * @package App\Services
 */
class UploadService
{
    /**
     * @param $path
     * @param $file
     * @param null $fileName
     * @return mixed|string|null
     */
    public function saveFile($path, $file, $fileName = null)
    {
        if (!$fileName) {
            $fileName = Str::uuid() . '.' . $this->getFileExtension($file);
        }

        Storage::putFileAs(
            $path, $file, $fileName
        );

        return $fileName;
    }

    /**
     * @param $path
     * @param $file
     * @param $oldFileName
     * @param null $fileName
     * @return mixed|string|null
     */
    public function updateFile($path, $file, $oldFileName, $fileName = null)
    {
        $this->deleteFile($path, $oldFileName);

        return $this->saveFile($path, $file, $fileName);
    }

    /**
     * @param $path
     * @param null $fileName
     * @return bool
     */
    public function deleteFile($path, $fileName = null)
    {
        if ($fileName) {
            $path = $path.$fileName;
        }

        return Storage::delete($path);
    }

    /**
     * @param $file
     * @return mixed
     */
    public function getFileExtension($file)
    {
        return $file->extension();
    }
}
