<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final readonly class CountryInfoReader implements ReaderInterface
{
    private ReaderInterface $reader;

    public function __construct()
    {
        $this->reader = new ExcelReader([
            'ISO',
            'ISO3',
            'ISO-Numeric',
            'fips',
            'Country',
            'Capital',
            'Area(in sq km)',
            'Population',
            'Continent',
            'tld',
            'CurrencyCode',
            'CurrencyName',
            'Phone',
            'Postal Code Format',
            'Postal Code Regex',
            'Languages',
            'geonameid',
            'neighbours',
            'EquivalentFipsCode',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getRecords(string $path): LazyCollection
    {
        return $this->reader
            ->getRecords($path)
            ->reject(fn (array $row) => \str_contains($row['ISO'], '#'));
    }
}
