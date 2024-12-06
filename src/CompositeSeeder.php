<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

final readonly class CompositeSeeder implements LoggerAwareInterface, SeederInterface
{
    /**
     * The seeder list.
     *
     * @var list<SeederInterface>
     */
    private array $seeders;

    /**
     * Make a new seeder instance.
     */
    public function __construct(SeederInterface ...$seeder)
    {
        $this->seeders = $seeder;
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    public function setLogger(LoggerInterface $logger): void
    {
        foreach ($this->seeders as $seeder) {
            if ($seeder instanceof LoggerAwareInterface) {
                $seeder->setLogger($logger);
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    #[\Override()]
    public function seed(): void
    {
        foreach ($this->seeders as $seeder) {
            $seeder->seed();
        }
    }
}
