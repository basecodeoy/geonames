<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

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
    #[\Override()]
    protected function loadResourcesBeforeMapping(): void
    {
        $this->loadCountries();
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getRecords(): LazyCollection
    {
        return $this->dataSource->getTimeZones();
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getModel(): string
    {
        return TimeZone::class;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getSyncKeyName(): array
    {
        return ['country_id', 'code'];
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
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
