<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\Component;
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

        $this->app->alias(LaravelLivewireDiscoverData::class, 'laravel-livewire-discover');

        $this->app->singleton(LaravelLivewireDiscoverData::class);

        $this->app->extend(LivewireManager::class, function () {
            return new LaravelLivewireDiscoverManager();
        });

        $this->app->instance(ComponentRegistry::class, new LaravelLivewireDiscoverComponentRegistry());
    }

    /**
     * Booting the package.
     *
     * @return void
     */
    public function bootingPackage(): void
    {
        Component::macro('updateNameFromClass', function () {
            $alias = app(LaravelLivewireDiscoverData::class)->getAliasFormClass(get_class($this));

            if ($alias) {
                $this->setName($alias);
            }
        });
    }
}
