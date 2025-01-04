<?php

namespace Eximius\Nincomply;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NincomplyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-nincomply-sso')
            ->hasConfigFile();
            //->hasViews()
            //->hasMigration('create_laravel_nincomply_sso_table');
            //->hasCommand(NincomplyCommand::class);
    }
}
