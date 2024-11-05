<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\Facades\Config;
use TypeError;

final class Configuration implements ConfigurationInterface
{
    public function getAdministrativeCodeModel(): string
    {
        return $this->getStringValue('geonames.models.administrative_code');
    }

    public function getAdministrativeCodeTableName(): string
    {
        return $this->getStringValue('geonames.tables.administrative_code');
    }

    public function getAlternateNameModel(): string
    {
        return $this->getStringValue('geonames.models.alternate_name');
    }

    public function getAlternateNameTableName(): string
    {
        return $this->getStringValue('geonames.tables.alternate_name');
    }

    public function getCityModel(): string
    {
        return $this->getStringValue('geonames.models.city');
    }

    public function getCityTableName(): string
    {
        return $this->getStringValue('geonames.tables.city');
    }

    public function getContinentModel(): string
    {
        return $this->getStringValue('geonames.models.continent');
    }

    public function getContinentTableName(): string
    {
        return $this->getStringValue('geonames.tables.continent');
    }

    public function getCountryModel(): string
    {
        return $this->getStringValue('geonames.models.country');
    }

    public function getCountryTableName(): string
    {
        return $this->getStringValue('geonames.tables.country');
    }

    public function getDivisionModel(): string
    {
        return $this->getStringValue('geonames.models.division');
    }

    public function getDivisionTableName(): string
    {
        return $this->getStringValue('geonames.tables.division');
    }

    public function getFeatureCodeModel(): string
    {
        return $this->getStringValue('geonames.models.feature_code');
    }

    public function getFeatureCodeTableName(): string
    {
        return $this->getStringValue('geonames.tables.feature_code');
    }

    public function getLanguageModel(): string
    {
        return $this->getStringValue('geonames.models.language');
    }

    public function getLanguageTableName(): string
    {
        return $this->getStringValue('geonames.tables.language');
    }

    public function getPostalCodeModel(): string
    {
        return $this->getStringValue('geonames.models.postal_code');
    }

    public function getPostalCodeTableName(): string
    {
        return $this->getStringValue('geonames.tables.postal_code');
    }

    public function getTimeZoneModel(): string
    {
        return $this->getStringValue('geonames.models.time_zone');
    }

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

        throw new TypeError("Configuration value '{$key}' must be a string.");
    }
}
