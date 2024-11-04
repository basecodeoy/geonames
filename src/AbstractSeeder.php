<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\LazyCollection;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;
use RuntimeException;

abstract class AbstractSeeder implements LoggerAwareInterface, SeederInterface
{
    use LoggerAwareTrait;

    /**
     * The chunk size of the records.
     */
    private int $chunkSize = 1000;

    public function __construct(protected readonly DataSource $dataSource)
    {
        $this->setLogger(new NullLogger());
    }

    /**
     * {@inheritDoc}
     */
    public function seed(): void
    {
        $this->logger->info('Start seeding records using "{seeder}" class', ['seeder' => static::class]);

        foreach ($this->getRecordsForSeeding()->chunk($this->chunkSize) as $chunk) {
            $this->newQuery()->upsert($chunk->all(), $this->getSyncKeyName());
        }

        $this->logger->info('Finish seeding records using "{seeder}" class', ['seeder' => static::class]);
    }

    /**
     * Load resources before records mapping of records.
     */
    protected function loadResourcesBeforeMapping(): void
    {
        //
    }

    /**
     * Unload resources after mapping of records.
     */
    protected function unloadResourcesAfterMapping(): void
    {
        //
    }

    /**
     * Load resources before mapping of chunk records.
     */
    protected function loadResourcesBeforeChunkMapping(LazyCollection $records): void
    {
        //
    }

    /**
     * Unload resources after mapping of chunk records.
     */
    protected function unloadResourcesAfterChunkMapping(LazyCollection $records): void
    {
        //
    }

    /**
     * Map records for seeding.
     */
    protected function mapRecordForSeeding(array $record): array
    {
        return $this->mapAttributes($record);
    }

    /**
     * Determine if the given record should be seeded.
     */
    protected function filter(array $record): bool
    {
        return true;
    }

    /**
     * Get the source records.
     */
    abstract protected function getModel(): string;

    /**
     * Get the sync key of the seeder.
     */
    abstract protected function getSyncKeyName(): array;

    /**
     * Get the source records.
     */
    abstract protected function getRecords(): LazyCollection;

    /**
     * Map fields to the model attributes.
     */
    abstract protected function mapAttributes(array $record): array;

    /**
     * Get mapped records for seeding.
     */
    private function getRecordsForSeeding(): LazyCollection
    {
        return new LazyCollection(function () {
            $this->loadResourcesBeforeMapping();

            foreach ($this->getRecordsAsCollection()->chunk($this->chunkSize) as $chunk) {
                $this->loadResourcesBeforeChunkMapping($chunk);

                foreach ($this->mapRecords($chunk) as $record) {
                    yield $record;
                }

                $this->unloadResourcesAfterChunkMapping($chunk);
            }

            $this->unloadResourcesAfterMapping();
        });
    }

    /**
     * Get a collection of records.
     */
    private function getRecordsAsCollection(): LazyCollection
    {
        return new LazyCollection(function () {
            foreach ($this->getRecords() as $record) {
                yield $record;
            }
        });
    }

    /**
     * Map records for seeding.
     */
    private function mapRecords(LazyCollection $records): iterable
    {
        foreach ($records as $record) {
            if ($this->filter($record)) {
                yield $this->mapRecordForSeeding($record);
            }
        }
    }

    /**
     * Get a new model instance of the seeder.
     */
    private function newModel(): Model
    {
        $model = $this->getModel();

        if (\is_a($model, Model::class, true)) {
            return new $model();
        }

        throw new RuntimeException(\sprintf('The seeder model "%s" is not an Eloquent model.', $model));
    }

    /**
     * Get a query instance of the seeder's model.
     */
    private function newQuery(): Builder
    {
        return static::newModel()->newQuery();
    }
}
