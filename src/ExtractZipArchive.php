<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use ZipArchive;
use const DIRECTORY_SEPARATOR;

final class ExtractZipArchive
{
    public static function extract(string $path): string
    {
        $directory = \pathinfo($path, \PATHINFO_DIRNAME);
        $file = \pathinfo($path, \PATHINFO_FILENAME).'.txt';
        $destination = $directory.DIRECTORY_SEPARATOR.$file;

        if (!\file_exists($destination)) {
            $zip = new ZipArchive();
            $zip->open($path);
            $zip->extractTo($directory, $file);
            $zip->close();
        }

        return $destination;
    }
}
