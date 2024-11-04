<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\LazyCollection;

final class TimeZoneSeeder extends AbstractSeeder
{
    /**
     * The countries that are stored in the database.
     */
    private array $countries = [];

    /**
     * {@inheritDoc}
     */
    protected function loadResourcesBeforeMapping(): void
    {
        $this->loadCountries();
    }

    /**
     * {@inheritDoc}
     */
    protected function getRecords(): LazyCollection
    {
        return $this->dataSource->getTimeZones();
    }

    /**
     * {@inheritDoc}
     */
    protected function getModel(): string
    {
        return TimeZone::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function getSyncKeyName(): array
    {
        return ['country_id', 'code'];
    }

    /**
     * {@inheritDoc}
     */
    protected function mapAttributes(array $record): array
    {
        return [
            'country_id' => $this->countries[$record['CountryCode']],
            'code' => $record['TimeZoneId'],
            'gmt_offset' => $record['GMT Offset'],
            'dst_offset' => $record['DST Offset'],
            'raw_offset' => $record['Raw Offset'],
        ];
    }

    private function loadCountries(): void
    {
        $this->countries = $this->newCountryModel()->newQuery()
            ->pluck('id', 'iso')
            ->all();
    }

    private function newCountryModel(): Model
    {
        return App::make(GeoNames::getCountryModel());
    }
}
