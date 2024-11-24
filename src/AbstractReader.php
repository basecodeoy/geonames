<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

abstract readonly class AbstractReader implements ReaderInterface
{
    private ReaderInterface $reader;

    public function __construct()
    {
        $this->reader = new ExcelReader($this->headers());
    }

    /**
     * {@inheritDoc}
     */
    public function getRecords(string $path): LazyCollection
    {
        return $this->reader->getRecords($path);
    }

    /**
     * The headers of the CSV file.
     */
    abstract protected function headers(): array;
}
