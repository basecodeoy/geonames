<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;
use Spatie\SimpleExcel\SimpleExcelReader;

final readonly class ExcelReader implements ReaderInterface
{
    public function __construct(private array $headers) {}

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
