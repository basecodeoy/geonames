<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;
use const DIRECTORY_SEPARATOR;

final class Downloader implements DownloaderInterface
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
        $this->directory = \rtrim($directory, DIRECTORY_SEPARATOR);
    }

    public function downloadPostalCodes(): array
    {
        /** @var list<string> $contents */
        $contents = [];

        foreach (Config::get('geonames.sources.postal_codes') as $source) {
            $path = \str_replace('.csv', '', $source).'.zip';
            $response = Http::get("https://download.geonames.org/export/zip/{$source}.zip");

            if ($response->failed()) {
                throw new InvalidArgumentException("The {$path} file could not be downloaded.");
            }

            $contents[] = $this->processResponse('zip', $path, $response);
        }

        return $contents;
    }

    public function downloadAdmin1Codes(): string
    {
        return $this->download('admin1CodesASCII.txt');
    }

    public function downloadAdmin2Codes(): string
    {
        return $this->download('admin2Codes.txt');
    }

    public function downloadLanguages(): string
    {
        return $this->download('iso-languagecodes.txt');
    }

    public function downloadTimeZones(): string
    {
        return $this->download('timeZones.txt');
    }

    public function downloadFeatureCodes(): string
    {
        return $this->download('featureCodes_en.txt');
    }

    /**
     * Download the geonames country info file.
     */
    public function downloadCountryInfo(): string
    {
        return $this->download('countryInfo.txt');
    }

    /**
     * Download the all countries file.
     */
    public function downloadAllCountries(): string
    {
        return $this->download('allCountries.zip');
    }

    /**
     * Download a single country file by the given country code.
     */
    public function downloadSingleCountry(string $country): string
    {
        return $this->download("{$country}.zip");
    }

    /**
     * Download an alternate names file.
     */
    public function downloadAlternateNames(): string
    {
        return $this->download('alternateNames.zip');
    }

    /**
     * Download an alternate names version 2 file.
     */
    public function downloadAlternateNamesV2(): string
    {
        return $this->download('alternateNamesV2.zip');
    }

    /**
     * Download an alternate names file of a single country by the given country code.
     */
    public function downloadSingleCountryAlternateNames(string $country): string
    {
        return $this->download("alternatenames/{$country}.zip");
    }

    /**
     * Download geonames daily modifications file.
     */
    public function downloadDailyModifications(): string
    {
        return $this->download($this->getDailyUpdateUrlByType('modifications'));
    }

    /**
     * Download geonames daily deletes file.
     */
    public function downloadDailyDeletes(): string
    {
        return $this->download($this->getDailyUpdateUrlByType('deletes'));
    }

    /**
     * Download geonames daily alternate name modifications file.
     */
    public function downloadDailyAlternateNamesModifications(): string
    {
        return $this->download($this->getDailyUpdateUrlByType('alternateNamesModifications'));
    }

    /**
     * Download geonames daily alternate name deletes file.
     */
    public function downloadDailyAlternateNamesDeletes(): string
    {
        return $this->download($this->getDailyUpdateUrlByType('alternateNamesDeletes'));
    }

    /**
     * Download a "cities" file by the given population.
     */
    public function downloadCities(int $population): string
    {
        $this->ensurePopulationAvailable($population);

        return $this->download("cities{$population}.zip");
    }

    /**
     * Download a file with no country related locations.
     */
    public function downloadNoCountry(): string
    {
        return $this->download('no-country.zip');
    }

    /**
     * Get the URL of the geonames daily deletes file.
     */
    private function getDailyUpdateUrlByType(string $type): string
    {
        return "{$type}-{$this->getGeonamesLastUpdateDate()->format('Y-m-d')}.txt";
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
        return "https://download.geonames.org/export/{$directory}/";
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
            throw new InvalidArgumentException(
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
     * @return int[]
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
        $destination = $this->directory.DIRECTORY_SEPARATOR.\trim(\dirname($path), '.');
        $destination = "{$destination}/{$directory}/{$path}";

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
