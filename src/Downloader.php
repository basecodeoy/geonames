<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

final readonly class Downloader implements DownloaderInterface
{
    /**
     * The path of directory for downloads.
     */
    private string $directory;

    /**
     * Make a new downloader instance.
     */
    public function __construct(string $directory)
    {
        $this->directory = \rtrim($directory, \DIRECTORY_SEPARATOR);
    }

    #[\Override()]
    public function downloadPostalCodes(): array
    {
        /** @var list<string> $contents */
        $contents = [];

        foreach (Config::get('geonames.sources.postal_codes') as $source) {
            $path = \str_replace('.csv', '', $source).'.zip';
            $response = Http::get(\sprintf('https://download.geonames.org/export/zip/%s.zip', $source));

            if ($response->failed()) {
                throw new \InvalidArgumentException(\sprintf('The %s file could not be downloaded.', $path));
            }

            $contents[] = $this->processResponse('zip', $path, $response);
        }

        return $contents;
    }

    #[\Override()]
    public function downloadAdmin1Codes(): string
    {
        return $this->download('admin1CodesASCII.txt');
    }

    #[\Override()]
    public function downloadAdmin2Codes(): string
    {
        return $this->download('admin2Codes.txt');
    }

    #[\Override()]
    public function downloadLanguages(): string
    {
        return $this->download('iso-languagecodes.txt');
    }

    #[\Override()]
    public function downloadTimeZones(): string
    {
        return $this->download('timeZones.txt');
    }

    #[\Override()]
    public function downloadFeatureCodes(): string
    {
        return $this->download('featureCodes_en.txt');
    }

    /**
     * Download the geonames country info file.
     */
    #[\Override()]
    public function downloadCountryInfo(): string
    {
        return $this->download('countryInfo.txt');
    }

    /**
     * Download the all countries file.
     */
    #[\Override()]
    public function downloadAllCountries(): string
    {
        return $this->download('allCountries.zip');
    }

    /**
     * Download a single country file by the given country code.
     */
    #[\Override()]
    public function downloadSingleCountry(string $country): string
    {
        return $this->download($country.'.zip');
    }

    /**
     * Download an alternate names file.
     */
    #[\Override()]
    public function downloadAlternateNames(): string
    {
        return $this->download('alternateNames.zip');
    }

    /**
     * Download an alternate names version 2 file.
     */
    #[\Override()]
    public function downloadAlternateNamesV2(): string
    {
        return $this->download('alternateNamesV2.zip');
    }

    /**
     * Download an alternate names file of a single country by the given country code.
     */
    #[\Override()]
    public function downloadSingleCountryAlternateNames(string $country): string
    {
        return $this->download(\sprintf('alternatenames/%s.zip', $country));
    }

    /**
     * Download geonames daily modifications file.
     */
    #[\Override()]
    public function downloadDailyModifications(): string
    {
        return $this->download($this->getDailyUpdateUrlByType('modifications'));
    }

    /**
     * Download geonames daily deletes file.
     */
    #[\Override()]
    public function downloadDailyDeletes(): string
    {
        return $this->download($this->getDailyUpdateUrlByType('deletes'));
    }

    /**
     * Download geonames daily alternate name modifications file.
     */
    #[\Override()]
    public function downloadDailyAlternateNamesModifications(): string
    {
        return $this->download($this->getDailyUpdateUrlByType('alternateNamesModifications'));
    }

    /**
     * Download geonames daily alternate name deletes file.
     */
    #[\Override()]
    public function downloadDailyAlternateNamesDeletes(): string
    {
        return $this->download($this->getDailyUpdateUrlByType('alternateNamesDeletes'));
    }

    /**
     * Download a "cities" file by the given population.
     */
    #[\Override()]
    public function downloadCities(int $population): string
    {
        $this->ensurePopulationAvailable($population);

        return $this->download(\sprintf('cities%d.zip', $population));
    }

    /**
     * Download a file with no country related locations.
     */
    #[\Override()]
    public function downloadNoCountry(): string
    {
        return $this->download('no-country.zip');
    }

    /**
     * Get the URL of the geonames daily deletes file.
     */
    private function getDailyUpdateUrlByType(string $type): string
    {
        return \sprintf('%s-%s.txt', $type, $this->getGeonamesLastUpdateDate()->format('Y-m-d'));
    }

    /**
     * Get the previous date of geonames updates.
     */
    private function getGeonamesLastUpdateDate(): Carbon
    {
        return Carbon::yesterday('UTC');
    }

    /**
     * Get the base URL for downloading geonames resources.
     */
    private function baseUrl(string $directory): string
    {
        return \sprintf('https://download.geonames.org/export/%s/', $directory);
    }

    /**
     * Get the final URL to the given geonames resource path.
     */
    private function url(string $path, string $directory): string
    {
        return $this->baseUrl($directory).\ltrim($path, '/');
    }

    /**
     * Assert that the given population is available to download.
     */
    private function ensurePopulationAvailable(int $population): void
    {
        if (!\in_array($population, $this->getPopulations(), true)) {
            throw new \InvalidArgumentException(
                \vsprintf('There is no file with "%s" population. Specify one of: %s', [
                    $population,
                    \implode(', ', $this->getPopulations()),
                ]),
            );
        }
    }

    /**
     * Get available populations for cities resource.
     *
     * @return array<int>
     */
    private function getPopulations(): array
    {
        return Config::get('geonames.sources.cities');
    }

    /**
     * Perform the download process.
     */
    private function download(string $path, string $directory = 'dump'): string
    {
        return $this->processResponse($directory, $path, Http::get($this->url($path, $directory)));
    }

    private function processResponse(string $directory, string $path, Response $response): string
    {
        $destination = $this->directory.\DIRECTORY_SEPARATOR.\trim(\dirname($path), '.');
        $destination = \sprintf('%s/%s/%s', $destination, $directory, $path);

        if (File::exists($destination)) {
            File::delete($destination);
        }

        File::put($destination, $response->body());

        if (\pathinfo($destination, \PATHINFO_EXTENSION) === 'zip') {
            return ExtractZipArchive::extract($destination);
        }

        return $destination;
    }
}
