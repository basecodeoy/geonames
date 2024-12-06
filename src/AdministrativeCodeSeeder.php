<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final class AdministrativeCodeSeeder extends AbstractSeeder
{
    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getRecords(): LazyCollection
    {
        $lazyCollection = $this->dataSource->getAdministrativeCodes1();
        $admin2 = $this->dataSource->getAdministrativeCodes2();

        return $lazyCollection->merge($admin2);
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getModel(): string
    {
        return AdministrativeCode::class;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getSyncKeyName(): array
    {
        return ['geoname_id'];
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function mapAttributes(array $record): array
    {
        return [
            'geoname_id' => $record['geonameid'],
            'code' => $record['code'],
            'name' => $record['name'],
            'name_ascii' => $record['name ascii'],
        ];
    }
}
