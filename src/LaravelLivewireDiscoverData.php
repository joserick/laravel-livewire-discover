<?php

namespace Joserick\LaravelLivewireDiscover;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LaravelLivewireDiscoverData
{
    private Collection $class_namespaces;

    /**
     * Create a new component resolver instance.
     */
    public function __construct()
    {
        $this->class_namespaces = collect();

        foreach (config('livewire-discover.class_namespaces') as $prefix => $class_namespace) {
            $this->add($prefix, $class_namespace);
        }
    }

    /**
     * Add a class/namespace prefix to the resolver.
     */
    public function add(
        string $prefix,
        string|array $class_namespace,
        ?string $class_path = null,
        ?string $view_path = null,
    ): void {
        if (is_array($class_namespace)) {
            $this->addFromArray($prefix, $class_namespace);
        } else {
            if ($class_path) {
                $class_path = rtrim(realpath($class_path), DIRECTORY_SEPARATOR).'/';
            }

            if ($view_path) {
                $view_path = rtrim(realpath($view_path), DIRECTORY_SEPARATOR).'/';
            }

            $this->put($prefix, [
                'class_namespace' => rtrim($class_namespace, '\\'),
                'class_path' => $class_path,
                'view_path' => $view_path,
            ]);
        }
    }

    /**
     * Clean the class namespaces collection.
     */
    public function clean(): void
    {
        $this->class_namespaces = collect();
    }

    /**
     * Get the collection of class namespaces to discover.
     */
    public function getClassNamespaces(): Collection
    {
        return $this->class_namespaces;
    }

    /**
     * Add config of prefix from array.
     */
    private function addFromArray(string $prefix, array $class_namespace): void
    {
        if (empty($class_namespace) || count($class_namespace) > 3) {
            throw new \Exception("The $prefix prefix configuration must have at least 1 or at most 3 elements");
        }

        $provided_keys = array_keys($class_namespace);

        if (array_keys($provided_keys) === $provided_keys) {
            $this->add($prefix, ...$class_namespace);
        } else {
            $required_keys = ['class_namespace', 'class_path', 'view_path'];

            foreach ($provided_keys as $key) {
                if (! in_array($key, $required_keys)) {
                    throw new \Exception("Invalid key $key in $prefix prefix config");
                }
            }

            $this->add($prefix, ...array_values(
                array_intersect_key($class_namespace, array_flip($required_keys))
            ));
        }
    }

    /**
     * Put the class namespace in the collection.
     */
    private function put(string $prefix, string|array $class_namespace): void
    {
        $this->class_namespaces->put($prefix, $class_namespace);
    }
}
