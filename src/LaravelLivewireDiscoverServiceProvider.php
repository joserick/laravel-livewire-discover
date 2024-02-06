<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\LivewireManager;
use Livewire\Mechanisms\ComponentRegistry;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelLivewireDiscoverServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     *
     * @param  \Spatie\LaravelPackageTools\Package $package
     * @return void
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-livewire-discover')
            ->hasConfigFile('laravel-livewire-discover');

        $this->app->alias(LaravelLivewireDiscover::class, 'laravel-livewire-discover');

        $this->app->singleton(LaravelLivewireDiscover::class);

        $this->app->extend(LivewireManager::class, function () {
            return new LaravelLivewireDiscoverManager();
        });

        // Load the Livewire components of xposbox.
        $this->app->instance(ComponentRegistry::class, new LaravelLivewireDiscoverComponentRegistry());
    }
}
