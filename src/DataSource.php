<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final readonly class DataSource
{
    public function __construct(
        private DownloaderInterface $downloader,
    ) {}

    public function getCountryInfoRecords(): LazyCollection
    {
        return (new CountryInfoReader())->getRecords(
            $this->downloader->downloadCountryInfo(),
        );
    }

    public function getRecords(): LazyCollection
    {
        return (new GeoNamesReader())->getRecords(
            $this->downloader->downloadAllCountries(),
        );
    }

    public function getAlternateNamesRecords(): LazyCollection
    {
        return (new AlternateNameReader())->getRecords(
            $this->downloader->downloadAlternateNamesV2(),
        );
    }

    public function getAdministrativeCodes1(): LazyCollection
    {
        return (new AdministrativeCodeReader())->getRecords(
            $this->downloader->downloadAdmin1Codes(),
        );
    }

    public function getAdministrativeCodes2(): LazyCollection
    {
        return (new AdministrativeCodeReader())->getRecords(
            $this->downloader->downloadAdmin2Codes(),
        );
    }

    public function getLanguages(): LazyCollection
    {
        return (new LanguageReader())->getRecords(
            $this->downloader->downloadLanguages(),
        );
    }

    public function getTimeZones(): LazyCollection
    {
        return (new TimeZoneReader())->getRecords(
            $this->downloader->downloadTimeZones(),
        );
    }

    public function getFeatureCodes(): LazyCollection
    {
        return (new FeatureCodeReader())->getRecords(
            $this->downloader->downloadFeatureCodes(),
        );
    }

    public function getPostalCodes(): LazyCollection
    {
        $postalCodeReader = new PostalCodeReader();
        $data = new LazyCollection();

        foreach ($this->downloader->downloadPostalCodes() as $path) {
            $data = $data->merge($postalCodeReader->getRecords($path));
        }

        return $data;
    }

    public function getCitiesRecords(int $population): LazyCollection
    {
        return (new GeoNamesReader())->getRecords(
            $this->downloader->downloadCities($population),
        );
    }

    public function getNoCountryRecords(): LazyCollection
    {
        return (new GeoNamesReader())->getRecords(
            $this->downloader->downloadNoCountry(),
        );
    }
}
