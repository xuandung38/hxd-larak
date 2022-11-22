<?php

namespace App\Helpers;

use Illuminate\Contracts\Filesystem\FileExistsException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\AdapterInterface;

class S3Uploader
{
    /**
     * Upload file to S3 storage.
     *
     * @param  UploadedFile  $file
     * @param    $s3Subdirectory
     * @param  null  $newName
     * @return mixed
     *
     * @throws FileExistsException
     */
    public static function upload(UploadedFile $file, $s3Subdirectory, $newName = null)
    {
        $fileName = ! empty($newName) ? $newName.'.'.$file->getClientOriginalExtension() : $file->getClientOriginalName();
        $filePath = self::generateUniqueS3FilePath($s3Subdirectory, $fileName);
        $s3 = Storage::disk('s3');

        $resource = fopen($file->getPathname(), 'r');
        $s3->writeStream($filePath, $resource, ['visibility' => AdapterInterface::VISIBILITY_PUBLIC]);
        fclose($resource);

        return $s3->url($filePath);
    }

    /**
     * @param $s3Subdirectory
     * @param $fileName
     * @return string
     */
    private static function generateUniqueS3FilePath($s3Subdirectory, $fileName): string
    {
        return rtrim(config('filesystems.disks.s3.directory'), '/').'/'.rtrim($s3Subdirectory, '/').'/'.uniqid().'_'.$fileName;
    }
}
