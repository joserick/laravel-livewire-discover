<?php

namespace Joserick\LaravelLivewireDiscover;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Mechanisms\ComponentRegistry;

class LaravelLivewireDiscover extends ComponentRegistry
{
    private string $class_namespace;
    private Collection $class_namespaces;

    /**
     * Create a new component resolver instance.
     */
    public function __construct() {
        $this->class_namespace = config('livewire.class_namespace');
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
     * Get the livewire class namespace.
     *
     * @return string
     */
    public function getClassNamespace() : string
    {
        return $this->class_namespace;
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

    /**
     * Get the prefix from the class.
     *
     * @param  string  $class
     * @return string|bool
     */
    function getPrefixFromClass(string $class) : string|bool
    {
        foreach ($this->class_namespaces as $prefix => $namespace) {
            if (Str::startsWith($class, $namespace)) {
                return $prefix;
            }
        }

        return false;
    }
}
