<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\LazyCollection;

final class CitySeeder extends AbstractSeeder
{
    /**
     * The minimum population filter.
     */
    protected int $minPopulation = 5_000;

    /**
     * The allowed feature codes.
     *
     * @var array<string>
     */
    protected array $featureCodes = [
        FeatureCodeEnum::PPL,
        FeatureCodeEnum::PPLC,
        FeatureCodeEnum::PPLA,
        FeatureCodeEnum::PPLA2,
        FeatureCodeEnum::PPLA3,
        FeatureCodeEnum::PPLG,
        FeatureCodeEnum::PPLS,
        FeatureCodeEnum::PPLX,
    ];

    /**
     * The countries that are stored in the database.
     */
    private array $countries = [];

    /**
     * The divisions that are stored in the database.
     */
    private array $divisions = [];

    /**
     * {@inheritDoc}
     */
    protected function loadResourcesBeforeMapping(): void
    {
        $this->loadCountries();

        $this->loadDivisions();
    }

    /**
     * {@inheritDoc}
     */
    protected function unloadResourcesAfterMapping(): void
    {
        $this->countries = [];
        $this->divisions = [];
    }

    /**
     * {@inheritDoc}
     */
    protected function filter(array $record): bool
    {
        return \in_array($record['feature code'], $this->featureCodes, true)
            && $record['population'] >= $this->minPopulation;
    }

    /**
     * {@inheritDoc}
     */
    protected function getRecords(): LazyCollection
    {
        // TODO: Add a configuration option to allow the user to change the population filter.
        return $this->dataSource->getCitiesRecords(500)
            ->merge($this->dataSource->getCitiesRecords(1_000))
            ->merge($this->dataSource->getCitiesRecords(5_000))
            ->merge($this->dataSource->getCitiesRecords(15_000));
    }

    /**
     * {@inheritDoc}
     */
    protected function getModel(): string
    {
        return City::class;
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
            'country_id' => $this->getCountryId($record),
            'division_id' => $this->getDivisionId($record),
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

    /**
     * Get a country ID by the given record.
     */
    private function getCountryId(array $record): int
    {
        return $this->countries[$record['country code']];
    }

    /**
     * Get a division ID by the given record.
     */
    private function getDivisionId(array $record): ?int
    {
        return $this->divisions[$this->getCountryId($record)][$record['admin1 code']][0]['id'] ?? null;
    }

    /**
     * Load country resources.
     */
    private function loadCountries(): void
    {
        /** @var Model $modelClass */
        $modelClass = GeoNames::getCountryModel();

        $this->countries = $modelClass::query()
            ->pluck('id', 'iso')
            ->all();
    }

    /**
     * Load division resources.
     */
    private function loadDivisions(): void
    {
        /** @var Model $modelClass */
        $modelClass = GeoNames::getDivisionModel();

        $this->divisions = $modelClass::query()
            ->get(['id', 'country_id', 'admin1_code'])
            ->groupBy(['country_id', 'admin1_code'])
            ->toArray();
    }
}
