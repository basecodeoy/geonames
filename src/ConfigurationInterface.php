<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

interface ConfigurationInterface
{
    public function getAdministrativeCodeModel(): string;

    public function getAdministrativeCodeTableName(): string;

    public function getAlternateNameModel(): string;

    public function getAlternateNameTableName(): string;

    public function getCityModel(): string;

    public function getCityTableName(): string;

    public function getContinentModel(): string;

    public function getContinentTableName(): string;

    public function getCountryModel(): string;

    public function getCountryTableName(): string;

    public function getDivisionModel(): string;

    public function getDivisionTableName(): string;

    public function getFeatureCodeModel(): string;

    public function getFeatureCodeTableName(): string;

    public function getLanguageModel(): string;

    public function getLanguageTableName(): string;

    public function getPostalCodeModel(): string;

    public function getPostalCodeTableName(): string;

    public function getTimeZoneModel(): string;

    public function getTimeZoneTableName(): string;
}
