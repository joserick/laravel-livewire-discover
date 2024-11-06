<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\LivewireManager;

class LaravelLivewireDiscoverManager extends LivewireManager
{
    /**
     * Create a new instance.
     */
    public function __construct(protected LivewireManager $livewireManager)
    {
        //
    }

    /**
     * Add a class / namespace prefix to the resolver.
     */
    public function componentNamespace(string $namespace, string $prefix): void
    {
        $this->discover($prefix, $namespace);
    }

    /**
     * Discover the components of the given namespace.
     */
    public function discover(
        string $prefix,
        string|array $namespace,
        ?string $class_path = null,
        ?string $view_path = null,
    ): void {
        LaravelLivewireDiscover::add($prefix, $namespace, $class_path, $view_path);
    }

    /**
     * Discover multiple components from the given array.
     */
    public function discovers(array $discovers): void
    {
        foreach ($discovers as $prefix => $namespace) {
            $this->discover($prefix, $namespace);
        }
    }

    /**
     * Call the LivewireManager methods.
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([$this->livewireManager, $method], $arguments);
    }
}
