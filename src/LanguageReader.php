<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final readonly class LanguageReader implements ReaderInterface
{
    private ReaderInterface $reader;

    public function __construct()
    {
        $this->reader = new ExcelReader([
            'ISO 639-3',
            'ISO 639-2',
            'ISO 639-1',
            'Language Name',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getRecords(string $path): LazyCollection
    {
        return $this->reader->getRecords($path);
    }
}
