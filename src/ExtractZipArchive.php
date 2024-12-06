<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

final class ExtractZipArchive
{
    public static function extract(string $path): string
    {
        $directory = \pathinfo($path, \PATHINFO_DIRNAME);
        $file = \pathinfo($path, \PATHINFO_FILENAME).'.txt';
        $destination = $directory.\DIRECTORY_SEPARATOR.$file;

        if (!\file_exists($destination)) {
            $zipArchive = new \ZipArchive();
            $zipArchive->open($path);
            $zipArchive->extractTo($directory, $file);
            $zipArchive->close();
        }

        return $destination;
    }
}
