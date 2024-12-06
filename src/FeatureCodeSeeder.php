<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Illuminate\Support\LazyCollection;

final class FeatureCodeSeeder extends AbstractSeeder
{
    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getRecords(): LazyCollection
    {
        return $this->dataSource->getFeatureCodes();
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getModel(): string
    {
        return FeatureCode::class;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function getSyncKeyName(): array
    {
        return ['name'];
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    protected function mapAttributes(array $record): array
    {
        return [
            'name' => $record['name'],
            'description' => $record['description'],
        ];
    }
}
