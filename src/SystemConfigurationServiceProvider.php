<?php

namespace Underwork\SystemConfiguration;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Underwork\SystemConfiguration\Commands\SystemConfigurationCommand;

class SystemConfigurationServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('system-configurations')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_system_configurations_table')
            ->hasCommand(SystemConfigurationCommand::class);
    }
}
