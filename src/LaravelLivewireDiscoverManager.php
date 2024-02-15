<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\LivewireManager;

class LaravelLivewireDiscoverManager extends LivewireManager
{
    /**
     * Add a class / namespace prefix to the resolver.
     *
     * @param  string  $namespace
     * @param  string  $prefix
     * @return void
     */
    public function componentNamespace(string $namespace, string $prefix): void
    {
        LaravelLivewireDiscover::add($prefix, $namespace);
    }

    /**
     * Discover the components of the given namespace.
     *
     * @param  string  $namespace
     * @param  string  $prefix
     * @return void
     */
    public function discover(string $namespace, string $prefix): void
    {
        $this->componentNamespace($namespace, $prefix);
    }
}
