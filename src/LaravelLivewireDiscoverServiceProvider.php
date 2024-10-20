<?php

namespace Joserick\LaravelLivewireDiscover;

use Illuminate\Support\Facades\Cache;
use Livewire\Livewire;
use Livewire\LivewireManager;
use Livewire\Mechanisms\ComponentRegistry as LivewireComponentRegistry;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelLivewireDiscoverServiceProvider extends PackageServiceProvider
{
    /**
     * Configure the package.
     */
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-livewire-discover')
            ->hasConfigFile()
            ->hasCommands(
                Commands\MakeDiscoverCommand::class,
                Commands\MakeLivewireDiscoverCommand::class,
            );

        $this->app->alias(LaravelLivewireDiscoverData::class, 'laravel-livewire-discover');

        $this->app->singleton(LaravelLivewireDiscoverData::class);

        $this->app->extend(LivewireManager::class, function () {
            return new LaravelLivewireDiscoverManager;
        });

        $this->app->instance(LivewireComponentRegistry::class, new ComponentRegistry);
    }

    /**
     * Booting the package.
     */
    public function bootingPackage(): void
    {
        Livewire::resolveMissingComponent([ComponentResolver::class, 'resolve']);
    }
}
