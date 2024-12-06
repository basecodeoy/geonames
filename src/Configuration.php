<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\Facades\Config;

final class Configuration implements ConfigurationInterface
{
    #[\Override()]
    public function getAdministrativeCodeModel(): string
    {
        return $this->getStringValue('geonames.models.administrative_code');
    }

    #[\Override()]
    public function getAdministrativeCodeTableName(): string
    {
        return $this->getStringValue('geonames.tables.administrative_code');
    }

    #[\Override()]
    public function getAlternateNameModel(): string
    {
        return $this->getStringValue('geonames.models.alternate_name');
    }

    #[\Override()]
    public function getAlternateNameTableName(): string
    {
        return $this->getStringValue('geonames.tables.alternate_name');
    }

    #[\Override()]
    public function getCityModel(): string
    {
        return $this->getStringValue('geonames.models.city');
    }

    #[\Override()]
    public function getCityTableName(): string
    {
        return $this->getStringValue('geonames.tables.city');
    }

    #[\Override()]
    public function getContinentModel(): string
    {
        return $this->getStringValue('geonames.models.continent');
    }

    #[\Override()]
    public function getContinentTableName(): string
    {
        return $this->getStringValue('geonames.tables.continent');
    }

    #[\Override()]
    public function getCountryModel(): string
    {
        return $this->getStringValue('geonames.models.country');
    }

    #[\Override()]
    public function getCountryTableName(): string
    {
        return $this->getStringValue('geonames.tables.country');
    }

    #[\Override()]
    public function getDivisionModel(): string
    {
        return $this->getStringValue('geonames.models.division');
    }

    #[\Override()]
    public function getDivisionTableName(): string
    {
        return $this->getStringValue('geonames.tables.division');
    }

    #[\Override()]
    public function getFeatureCodeModel(): string
    {
        return $this->getStringValue('geonames.models.feature_code');
    }

    #[\Override()]
    public function getFeatureCodeTableName(): string
    {
        return $this->getStringValue('geonames.tables.feature_code');
    }

    #[\Override()]
    public function getLanguageModel(): string
    {
        return $this->getStringValue('geonames.models.language');
    }

    #[\Override()]
    public function getLanguageTableName(): string
    {
        return $this->getStringValue('geonames.tables.language');
    }

    #[\Override()]
    public function getPostalCodeModel(): string
    {
        return $this->getStringValue('geonames.models.postal_code');
    }

    #[\Override()]
    public function getPostalCodeTableName(): string
    {
        return $this->getStringValue('geonames.tables.postal_code');
    }

    #[\Override()]
    public function getTimeZoneModel(): string
    {
        return $this->getStringValue('geonames.models.time_zone');
    }

    #[\Override()]
    public function getTimeZoneTableName(): string
    {
        return $this->getStringValue('geonames.tables.time_zone');
    }

    private function getStringValue(string $key): string
    {
        $value = Config::get($key);

        if (\is_string($value)) {
            return $value;
        }

        throw new \TypeError(\sprintf("Configuration value '%s' must be a string.", $key));
    }
}
