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
use Illuminate\Support\Facades\App;
use Illuminate\Support\LazyCollection;

final class CountrySeeder extends AbstractSeeder
{
    /**
     * The allowed feature codes.
     *
     * @var array<string>
     */
    private array $featureCodes = [
        FeatureCodeEnum::PCLI,
        FeatureCodeEnum::PCLD,
        FeatureCodeEnum::TERR,
        FeatureCodeEnum::PCLIX,
        FeatureCodeEnum::PCLS,
        FeatureCodeEnum::PCLF,
        FeatureCodeEnum::PCL,
    ];

    /**
     * The country info list.
     */
    private array $countryInfo = [];

    /**
     * The continent list.
     */
    private array $continents = [];

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function loadResourcesBeforeMapping(): void
    {
        $this->loadCountryInfo();
        $this->loadContinents();
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function unloadResourcesAfterMapping(): void
    {
        $this->countryInfo = [];
        $this->continents = [];
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function filter(array $record): bool
    {
        if (\array_key_exists($record['geonameid'], $this->countryInfo)) {
            return \in_array($record['feature code'], $this->featureCodes, true);
        }

        return false;
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
        return Country::class;
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
        return \array_merge(
            $this->mapCountryInfoAttributes($record),
            [
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
            ],
        );
    }

    /**
     * Map attributes of the country info record.
     */
    private function mapCountryInfoAttributes(array $record): array
    {
        $countryInfo = $this->countryInfo[$record['geonameid']];

        return [
            'continent_id' => $this->continents[$countryInfo['Continent']],
            'iso' => $countryInfo['ISO'],
            'iso3' => $countryInfo['ISO3'],
            'iso_numeric' => $countryInfo['ISO-Numeric'],
            'fips' => $countryInfo['fips'],
            'country' => $countryInfo['Country'],
            'capital' => $countryInfo['Capital'],
            'area_in_sq_km' => $countryInfo['Area(in sq km)'],
            'tld' => $countryInfo['tld'],
            'currency_code' => $countryInfo['CurrencyCode'],
            'currency_name' => $countryInfo['CurrencyName'],
            'phone' => $countryInfo['Phone'],
            'postal_code_format' => $countryInfo['Postal Code Format'],
            'postal_code_regex' => $countryInfo['Postal Code Regex'],
            'languages' => $countryInfo['Languages'],
            'neighbours' => $countryInfo['neighbours'],
            'equivalent_fips_code' => $countryInfo['EquivalentFipsCode'],
        ];
    }

    /**
     * Load the country info resources.
     */
    private function loadCountryInfo(): void
    {
        foreach ($this->getCountryInfoRecords() as $countryInfoRecord) {
            $this->countryInfo[$countryInfoRecord['geonameid']] = $countryInfoRecord;
        }
    }

    /**
     * Get country info records.
     */
    private function getCountryInfoRecords(): LazyCollection
    {
        return $this->dataSource->getCountryInfoRecords();
    }

    /**
     * Load the continent resources.
     */
    private function loadContinents(): void
    {
        $this->continents = $this->newContinentModel()
            ->newQuery()
            ->pluck('id', 'code')
            ->all();
    }

    /**
     * Get the new continent model instance.
     */
    private function newContinentModel(): Model
    {
        return App::make(GeoNames::getContinentModel());
    }
}
