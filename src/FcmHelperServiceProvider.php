<?php

namespace AhmedHegazy\FcmHelper;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use AhmedHegazy\FcmHelper\Commands\FcmHelperCommand;

class FcmHelperServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('fcm-helper')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_fcm_helper_table')
            ->hasCommand(FcmHelperCommand::class);
    }
}
