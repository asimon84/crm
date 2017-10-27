<?php

namespace App\Portal\File;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class File
 *
 * Class to handle basic File functions
 *
 * @package App\Portal\File
 */
class File
{
    /**
     * @var string
     */
    public static $localPath = './upl/';

    /**
     * Method to upload a file, change this in order to utilize different storage services
     *
     * @param UploadedFile $file
     * @param string $name
     * @return mixed
     */
    public static function upload(UploadedFile $file, string $name) :mixed
    {
        return $file->move(self::$localPath, $name);
    }

    /**
     * Check if a passed filename exists, change this to utilize different storage services
     *
     * @param string $name
     * @return boolean
     */
    public static function exists(string $name) :boolean
    {
        return file_exists(self::$localPath . $name);
    }
}