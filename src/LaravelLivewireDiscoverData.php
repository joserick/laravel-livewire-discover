<?php

namespace Joserick\LaravelLivewireDiscover;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LaravelLivewireDiscoverData
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
    public function getPrefixFromClass(string $class) : string|bool
    {
        foreach ($this->class_namespaces as $prefix => $namespace) {
            if (Str::startsWith($class, $namespace)) {
                return $prefix;
            }
        }

        return false;
    }

    /**
     * Get the alias form class.
     *
     * @param  string  $class
     * @return string|bool
     */
    public function getAliasFormClass(string $class) : string|bool
    {
        if ($prefix = $this->getPrefixFromClass($class)) {
            return $prefix.'-'.str(substr(strrchr($class, '\\'), 1))->kebab();
        }

        return $prefix;
    }

    /**
     * Get the class from name with namespace.
     *
     * @param  string  $nameComponent
     * @return string|bool
     */
    public function getClassFromNameWithNamespace(string $nameComponent) : string|bool
    {
        $class = collect(str($nameComponent)->explode('.'))
            ->map(fn ($segment) => (string) str($segment)->studly())
            ->join('\\');

        if (class_exists($class)) {
            return $class;
        }

        return false;
    }
}
