<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Carbon\Carbon;
use Illuminate\Support\LazyCollection;
use InvalidArgumentException;

final class ContinentSeeder extends AbstractSeeder
{
    /**
     * {@inheritDoc}
     */
    protected function filter(array $record): bool
    {
        return $record['feature code'] === FeatureCodeEnum::CONT;
    }

    /**
     * {@inheritDoc}
     */
    protected function getRecords(): LazyCollection
    {
        return $this->dataSource->getRecords();
    }

    /**
     * {@inheritDoc}
     */
    protected function getModel(): string
    {
        return Continent::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function getSyncKeyName(): array
    {
        return ['geoname_id'];
    }

    /**
     * {@inheritDoc}
     */
    protected function mapAttributes(array $record): array
    {
        return [
            'geoname_id' => $record['geonameid'],
            'code' => $this->getContinentCode($record['name']),
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

    private function getContinentCode(string $name): string
    {
        return match ($name) {
            'Africa' => 'AF',
            'Antarctica' => 'AN',
            'Asia' => 'AS',
            'Europe' => 'EU',
            'North America' => 'NA',
            'Oceania' => 'OC',
            'South America' => 'SA',
            default => throw new InvalidArgumentException('Invalid continent name: '.$name),
        };
    }
}
