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
    public function __construct() {
        $this->class_namespaces = collect();

        foreach (config('laravel-livewire-discover.class_namespaces') as $prefix => $class_namespace) {
            $this->add($prefix, $class_namespace);
        }
    }

    /**
     * Add a class/namespace prefix to the resolver.
     *
     * @param  string  $prefix
     * @param  string  $namespace
     * @return void
     */
    public function add(string $prefix, string|array $class_namespace, ?string $class_path = null) : void
    {
        if (is_array($class_namespace)) {
            if (count($class_namespace) === 2){
                if (isset($class_namespace[0]) && isset($class_namespace[1])){
                    $this->add($prefix, $class_namespace[0], $class_namespace[1]);
                }else if (isset($class_namespace['class_namespace']) && isset($class_namespace['class_path'])){
                    $this->put($prefix, $class_namespace);
                }else{
                    throw new \Exception("The $prefix prefix config must have class_namespace and class_path elements");
                }
            }else{
                throw new \Exception("The $prefix prefix config must have 2 elements");
            }
        }else if ($class_path) {
            $this->put($prefix, [
                'class_namespace' => $class_namespace,
                'class_path' => $class_path,
            ]);
        }else{
            $this->put($prefix, $class_namespace);
        }
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

    private function put(string $prefix, string|array $class_namespace) : void
    {
        if (is_array($class_namespace)) {
            $class_namespace['class_path'] =
                Str::finish($class_namespace['class_path'], '/');
        }

        $this->class_namespaces->put($prefix, $class_namespace);
    }
}
