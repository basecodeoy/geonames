<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

interface DownloaderInterface
{
    /**
     * Download the postal codes file.
     */
    public function downloadPostalCodes(): array;

    /**
     * Download the administrative division codes file.
     */
    public function downloadAdmin1Codes(): string;

    /**
     * Download the administrative subdivision codes file.
     */
    public function downloadAdmin2Codes(): string;

    /**
     * Download the languages file.
     */
    public function downloadLanguages(): string;

    /**
     * Download the time zones file.
     */
    public function downloadTimeZones(): string;

    /**
     * Download the feature codes file.
     */
    public function downloadFeatureCodes(): string;

    /**
     * Download the geonames country info file.
     */
    public function downloadCountryInfo(): string;

    /**
     * Download the all countries file.
     */
    public function downloadAllCountries(): string;

    /**
     * Download a single country file by the given country code.
     */
    public function downloadSingleCountry(string $country): string;

    /**
     * Download an alternate names file.
     */
    public function downloadAlternateNames(): string;

    /**
     * Download an alternate names version 2 file.
     */
    public function downloadAlternateNamesV2(): string;

    /**
     * Download an alternate names file of a single country by the given country code.
     */
    public function downloadSingleCountryAlternateNames(string $country): string;

    /**
     * Download geonames daily modifications file.
     */
    public function downloadDailyModifications(): string;

    /**
     * Download geonames daily deletes file.
     */
    public function downloadDailyDeletes(): string;

    /**
     * Download geonames daily alternate name modifications file.
     */
    public function downloadDailyAlternateNamesModifications(): string;

    /**
     * Download geonames daily alternate name deletes file.
     */
    public function downloadDailyAlternateNamesDeletes(): string;

    /**
     * Download a "cities" file by the given population.
     */
    public function downloadCities(int $population): string;

    /**
     * Download a file with no country related locations.
     */
    public function downloadNoCountry(): string;
}
