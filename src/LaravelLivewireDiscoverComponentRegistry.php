<?php

namespace Joserick\LaravelLivewireDiscover;

use ArrayIterator;
use Illuminate\Support\Str;
use Livewire\Exceptions\ComponentNotFoundException;
use Livewire\Mechanisms\ComponentRegistry;

class LaravelLivewireDiscoverComponentRegistry extends ComponentRegistry
{
    protected function getNameAndClass($nameComponentOrClass)
    {
        $class_namespace = config('livewire.class_namespace');

        $name_class = $this->getNameAndClassDiscovered($nameComponentOrClass,
            collect(config('laravel-livewire-discover.class_namespaces'))->getIterator());

        config(['livewire.class_namespace' => $class_namespace]);

        return $name_class;
    }

    private function getNameAndClassDiscovered($nameComponentOrClass, ArrayIterator $class_namespaces)
    {
        try {
            return parent::getNameAndClass($nameComponentOrClass);
        } catch (ComponentNotFoundException $th) {
            if ($class_namespaces->valid()) {
                if (Str::startsWith($nameComponentOrClass, $class_namespaces->key())) {
                    $nameComponentOrClass = Str::replaceFirst($class_namespaces->key().'-', '', $nameComponentOrClass);
                }
                config(['livewire.class_namespace' => $class_namespaces->current()]);
                $class_namespaces->next();
            } else {
                throw $th;
            }

            return $this->getNameAndClassDiscovered($nameComponentOrClass, $class_namespaces);
        }
    }
}
