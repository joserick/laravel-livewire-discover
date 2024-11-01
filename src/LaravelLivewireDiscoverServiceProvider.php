<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\Livewire;
use Livewire\LivewireManager;
use Livewire\Mechanisms\ComponentRegistry as LivewireComponentRegistry;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
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
            ->publishesServiceProvider('LivewireDiscoverServiceProvider')
            ->hasInstallCommand([$this, 'installConfig'])
            ->hasConfigFile()
            ->hasCommands(
                Commands\MakeDiscoverCommand::class,
                Commands\MakeLivewireDiscoverCommand::class,
            );
    }

    public function packageRegistered(): void
    {
        $this->app->alias(LaravelLivewireDiscoverData::class, $this->package->name);

        $this->app->singleton(LaravelLivewireDiscoverData::class);

        $this->app->extend(LivewireManager::class, function (LivewireManager $livewireManager) {
            return new LaravelLivewireDiscoverManager($livewireManager);
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

    /**
     * Installation configuration for command.
     */
    public function installConfig(InstallCommand $install_command): void
    {
        $install_command->copyAndRegisterServiceProviderInApp()
            ->askToStarRepoOnGitHub('joserick/'.$this->package->name)
            ->publishConfigFile();
    }
}
