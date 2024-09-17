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
        $this->discover($namespace, $prefix);
    }

    /**
     * Discover the components of the given namespace.
     *
     * @param  string  $namespace
     * @param  string  $prefix
     * @return void
     */
    public function discover(string $prefix, string|array $namespace, ?string $class_path = null): void
    {
        LaravelLivewireDiscover::add($prefix, $namespace, $class_path);
    }


    /**
     * Discover multiple components from the given array.
     *
     * @param  array  $discovers
     * @return void
     */
    public function discovers(array $discovers): void
    {
        foreach ($discovers as $prefix => $namespace) {
            $this->discover($prefix, $namespace);
        }
    }
}
