<?php

declare(strict_types=1);

namespace BaseCodeOy\GeoNames;

use Illuminate\Console\Command;

final class SeederCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'geonames:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed data from geonames.org';

    /**
     * Execute the console command.
     */
    public function handle(CompositeSeeder $seeder): void
    {
        $seeder->seed();
    }
}
