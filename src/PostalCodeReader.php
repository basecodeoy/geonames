<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final readonly class PostalCodeReader implements ReaderInterface
{
    private ReaderInterface $reader;

    public function __construct()
    {
        $this->reader = new ExcelReader([
            'country_code',
            'postal_code',
            'place_name',
            'admin_name1',
            'admin_code1',
            'admin_name2',
            'admin_code2',
            'admin_name3',
            'admin_code3',
            'latitude',
            'longitude',
            'accuracy',
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
