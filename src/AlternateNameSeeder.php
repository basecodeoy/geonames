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
use Illuminate\Support\LazyCollection;

final class AlternateNameSeeder extends AbstractSeeder
{
    private array $languagesByIso6391 = [];

    private array $languagesByIso6392 = [];

    private array $languagesByIso6393 = [];

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function loadResourcesBeforeMapping(): void
    {
        $this->loadLanguages();
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function unloadResourcesAfterMapping(): void
    {
        $this->languagesByIso6392 = [];
        $this->languagesByIso6393 = [];
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getRecords(): LazyCollection
    {
        return $this->dataSource->getAlternateNamesRecords();
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getModel(): string
    {
        return AlternateName::class;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getSyncKeyName(): array
    {
        return ['geoname_id', 'alternate_name_id'];
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function mapAttributes(array $record): array
    {
        $languageId = null;

        if (\in_array($record['isolanguage'], ['post', 'iata', 'icao', 'faac', 'fr_1793', 'abbr', 'link', 'wkdt'], true)) {
            $type = $record['isolanguage'];
        } elseif ($record['isolanguage'] === '') {
            $type = 'unknown';
        } else {
            $type = 'iso';
            $languageId = $this->getLanguageId($record);
        }

        return [
            'language_id' => $languageId,
            'geoname_id' => $record['geonameid'],
            'alternate_name_id' => $record['alternateNameId'],
            'type' => $type,
            'name' => $record['alternate'],
            'is_preferred_name' => $record['isPreferredName'] ?: false,
            'is_short_name' => $record['isShortName'] ?: false,
            'is_colloquial' => $record['isColloquial'] ?: false,
            'is_historic' => $record['isHistoric'] ?: false,
        ];
    }

    private function getLanguageId(array $record): ?int
    {
        $languageId = Arr::get($this->languagesByIso6393, $record['isolanguage']);

        if ($languageId === null) {
            $languageId = Arr::get($this->languagesByIso6392, $record['isolanguage']);
        }

        if ($languageId === null) {
            $languageId = Arr::get($this->languagesByIso6391, $record['isolanguage']);
        }

        if ($languageId === null) {
            $this->logger->warning(\sprintf('Language with ISO 639-1, ISO 639-2 or ISO 639-3 code %s not found.', $record['isolanguage']));
        }

        return $languageId;
    }

    private function loadLanguages(): void
    {
        /** @var Model $modelClass */
        $modelClass = GeoNames::getLanguageModel();

        $this->languagesByIso6391 = $modelClass::query()->pluck('id', 'iso_639_1')->all();
        $this->languagesByIso6392 = $modelClass::query()->pluck('id', 'iso_639_2')->all();
        $this->languagesByIso6393 = $modelClass::query()->pluck('id', 'iso_639_3')->all();
    }
}
