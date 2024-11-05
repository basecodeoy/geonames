<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final class AdministrativeCodeSeeder extends AbstractSeeder
{
    /**
     * {@inheritDoc}
     */
    protected function getRecords(): LazyCollection
    {
        $admin1 = $this->dataSource->getAdministrativeCodes1();
        $admin2 = $this->dataSource->getAdministrativeCodes2();

        return $admin1->merge($admin2);
    }

    /**
     * {@inheritDoc}
     */
    protected function getModel(): string
    {
        return AdministrativeCode::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function getSyncKeyName(): array
    {
        return ['geoname_id'];
    }

    /**
     * {@inheritDoc}
     */
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
