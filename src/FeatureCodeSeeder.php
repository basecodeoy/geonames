<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final class FeatureCodeSeeder extends AbstractSeeder
{
    /**
     * {@inheritDoc}
     */
    protected function getRecords(): LazyCollection
    {
        return $this->dataSource->getFeatureCodes();
    }

    /**
     * {@inheritDoc}
     */
    protected function getModel(): string
    {
        return FeatureCode::class;
    }

    /**
     * {@inheritDoc}
     */
    protected function getSyncKeyName(): array
    {
        return ['name'];
    }

    /**
     * {@inheritDoc}
     */
    protected function mapAttributes(array $record): array
    {
        return [
            'name' => $record['name'],
            'description' => $record['description'],
        ];
    }
}
