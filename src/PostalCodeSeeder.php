<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\LazyCollection;

final class PostalCodeSeeder extends AbstractSeeder
{
    /**
     * The countries that are stored in the database.
     */
    private array $countriesByGeo = [];

    /**
     * The countries that are stored in the database.
     */
    private array $countriesByIso = [];

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
        return $this->dataSource->getPostalCodes();
    }

    /**
     * {@inheritDoc}
     */
    protected function getModel(): string
    {
        return PostalCode::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function getSyncKeyName(): array
    {
        return ['country_code', 'postal_code'];
    }

    /**
     * {@inheritDoc}
     */
    protected function mapAttributes(array $record): array
    {
        $countryId = Arr::get($this->countriesByIso, $record['country_code']);

        if ($countryId === null) {
            $countryId = Arr::get($this->countriesByGeo, $record['country_code']);
        }

        if (empty($countryId)) {
            throw new \RuntimeException(
                \sprintf(
                    'Could not find country for postal code %s in %s',
                    $record['postal_code'],
                    $record['country_code'],
                ),
            );
        }

        return [
            'country_id' => $countryId,
            'country_code' => $record['country_code'],
            'postal_code' => $record['postal_code'],
            'place_name' => $record['place_name'],
            'admin_name1' => $record['admin_name1'],
            'admin_code1' => $record['admin_code1'],
            'admin_name2' => $record['admin_name2'],
            'admin_code2' => $record['admin_code2'],
            'admin_name3' => $record['admin_name3'],
            'admin_code3' => $record['admin_code3'],
            'latitude' => $record['latitude'],
            'longitude' => $record['longitude'],
            'accuracy' => $record['accuracy'],
        ];
    }

    private function loadCountries(): void
    {
        $this->countriesByGeo = $this->newCountryModel()->newQuery()->pluck('id', 'geoname_id')->all();
        $this->countriesByIso = $this->newCountryModel()->newQuery()->pluck('id', 'iso')->all();
    }

    private function newCountryModel(): Model
    {
        return App::make(GeoNames::getCountryModel());
    }
}
