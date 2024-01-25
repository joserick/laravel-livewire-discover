<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\LivewireManager;

class LaravelLivewireDiscoverManager extends LivewireManager
{
    public function componentNamespace(string $namespace, string $prefix) {
        $class_namespaces = collect(config('laravel-livewire-discover.class_namespaces'));
        $class_namespaces->put($prefix, $namespace);
        config(['laravel-livewire-discover.class_namespaces' => $class_namespaces->toArray()]);
    }

    public function discover(string $namespace, string $prefix)
    {
        $this->componentNamespace($namespace, $prefix);
    }
}
