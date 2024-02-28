<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\Livewire;
use Livewire\LivewireManager;
use Livewire\Mechanisms\ComponentRegistry as LivewireComponentRegistry;
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

        $this->app->alias(LaravelLivewireDiscoverData::class, 'laravel-livewire-discover');

        $this->app->singleton(LaravelLivewireDiscoverData::class);

        $this->app->extend(LivewireManager::class, function () {
            return new LaravelLivewireDiscoverManager();
        });

        $this->app->instance(LivewireComponentRegistry::class, new ComponentRegistry());
    }

    /**
     * Booting the package.
     *
     * @return void
     */
    public function bootingPackage(): void
    {
        Livewire::resolveMissingComponent([ComponentResolver::class, 'resolve']);
    }
}
