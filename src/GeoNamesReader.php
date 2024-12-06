<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final readonly class GeoNamesReader implements ReaderInterface
{
    private ReaderInterface $reader;

    public function __construct()
    {
        $this->reader = new ExcelReader([
            'geonameid',
            'name',
            'asciiname',
            'alternatenames',
            'latitude',
            'longitude',
            'feature class',
            'feature code',
            'country code',
            'cc2',
            'admin1 code',
            'admin2 code',
            'admin3 code',
            'admin4 code',
            'population',
            'elevation',
            'dem',
            'timezone',
            'modification date',
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
