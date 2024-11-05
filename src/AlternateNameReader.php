<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final readonly class AlternateNameReader implements ReaderInterface
{
    private ReaderInterface $reader;

    public function __construct()
    {
        $this->reader = new ExcelReader([
            'alternateNameId',
            'geonameid',
            'isolanguage',
            'alternate',
            'name',
            'isPreferredName',
            'isShortName',
            'isColloquial',
            'isHistoric',
            'from',
            'to',
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
