<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;
use Spatie\SimpleExcel\SimpleExcelReader;

final readonly class ExcelReader implements ReaderInterface
{
    public function __construct(
        private array $headers,
    ) {}

    /**
     * {@inheritDoc}
     */
    public function getRecords(string $path): LazyCollection
    {
        return SimpleExcelReader::create($path, 'csv')
            ->useDelimiter("\t")
            ->useHeaders($this->headers)
            ->getRows();
    }
}
