<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Carbon\Carbon;
use Illuminate\Support\LazyCollection;

final class DivisionSeeder extends AbstractSeeder
{
    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function filter(array $record): bool
    {
        return $record['feature code'] === FeatureCodeEnum::ADM1;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getRecords(): LazyCollection
    {
        return $this->dataSource->getRecords();
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getModel(): string
    {
        return Division::class;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getSyncKeyName(): array
    {
        return ['geoname_id'];
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function mapAttributes(array $record): array
    {
        return [
            // TODO: load all countries into memory
            'country_id' => Country::where('iso', $record['country code'])->firstOrFail()->id,
            'geoname_id' => $record['geonameid'],
            'name' => $record['name'],
            'name_ascii' => $record['asciiname'],
            'name_alternate' => $record['alternatenames'],
            'latitude' => $record['latitude'],
            'longitude' => $record['longitude'],
            'feature_class' => $record['feature class'],
            'feature_code' => $record['feature code'],
            'country_code' => $record['country code'],
            'country_code_alternate' => $record['cc2'],
            'admin1_code' => $record['admin1 code'],
            'admin2_code' => $record['admin2 code'],
            'admin3_code' => $record['admin3 code'],
            'admin4_code' => $record['admin4 code'],
            'population' => $record['population'],
            'elevation' => $record['elevation'],
            'digital_elevation_model' => $record['dem'],
            'timezone' => $record['timezone'],
            'last_modified_at' => Carbon::parse($record['modification date']),
        ];
    }
}
