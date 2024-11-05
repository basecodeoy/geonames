<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final readonly class AdministrativeCodeReader implements ReaderInterface
{
    private ReaderInterface $reader;

    public function __construct()
    {
        $this->reader = new ExcelReader(['code', 'name', 'name ascii', 'geonameid']);
    }

    /**
     * {@inheritDoc}
     */
    public function getRecords(string $path): LazyCollection
    {
        return $this->reader->getRecords($path);
    }
}
