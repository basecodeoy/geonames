<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\GeoNames;

use BaseCodeOy\PackagePowerPack\Package\AbstractServiceProvider;
use Illuminate\Database\Console\Seeds\SeedCommand;
use Spatie\LaravelPackageTools\Package;

final class ServiceProvider extends AbstractServiceProvider
{
    public function configurePackage(Package $package): void
    {
        parent::configurePackage($package);

        $package->hasCommand(SeedCommand::class);
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(
            ConfigurationInterface::class,
            Configuration::class,
        );
    }
}
