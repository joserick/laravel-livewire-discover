<?php

namespace Joserick\LaravelLivewireDiscover;

use Illuminate\Support\Collection;

class LaravelLivewireDiscoverData
{
    private Collection $class_namespaces;

    /**
     * Create a new component resolver instance.
     */
    public function __construct() {
        $this->class_namespaces = collect(config('laravel-livewire-discover.class_namespaces'));
    }

    /**
     * Add a class / namespace prefix to the resolver.
     *
     * @param  string  $prefix
     * @param  string  $namespace
     * @return void
     */
    public function add(string $prefix, string $namespace) : void
    {
        $this->class_namespaces->put($prefix, $namespace);
    }

    /**
     * Get the collection of class namespaces to discover.
     *
     * @return Collection
     */
    public function getClassNamespaces() : Collection
    {
        return $this->class_namespaces;
    }
}
