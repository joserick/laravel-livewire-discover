<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireDiscoverServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap the livewire-discover components.
     */
    public function boot(): void
    {
        // Load multiples namespace for Livewire components.
        Livewire::discovers([
            // 'my-components' => 'Namespaces\\Livewire',
        ]);

        // Or individually
        // Livewire::discover('my-components', 'Namespaces\\Livewire');
        // Livewire::discover('new-components', 'User\\Repository\\Livewire');

        // Livewire::componentNamespace('Namespaces\\Livewire', 'my-components');
        // Livewire::componentNamespace('User\\Repository\\Livewire', 'new-components');
    }
}
