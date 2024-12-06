<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final class LanguageSeeder extends AbstractSeeder
{
    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getRecords(): LazyCollection
    {
        return $this->dataSource->getLanguages();
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getModel(): string
    {
        return Language::class;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getSyncKeyName(): array
    {
        return ['name', 'iso_639_1', 'iso_639_2', 'iso_639_3'];
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function mapAttributes(array $record): array
    {
        return [
            'name' => $record['Language Name'],
            'iso_639_1' => $record['ISO 639-1'] ?: null,
            'iso_639_2' => $record['ISO 639-2'] ?: null,
            'iso_639_3' => $record['ISO 639-3'],
        ];
    }
}
