<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final readonly class TimeZoneReader implements ReaderInterface
{
    private ReaderInterface $reader;

    public function __construct()
    {
        $this->reader = new ExcelReader([
            'CountryCode',
            'TimeZoneId',
            'GMT Offset',
            'DST Offset',
            'Raw Offset',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    public function getRecords(string $path): LazyCollection
    {
        return $this->reader->getRecords($path);
    }
}
