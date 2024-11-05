<?php

declare(strict_types=1);

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
    public function __construct(SeederInterface ...$seeders)
    {
        $this->seeders = $seeders;
    }

    /**
     * {@inheritDoc}
     */
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
    public function seed(): void
    {
        foreach ($this->seeders as $seeder) {
            $seeder->seed();
        }
    }
}
