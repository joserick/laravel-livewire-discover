<?php

namespace Joserick\LaravelLivewireDiscover;

use ArrayIterator;
use Illuminate\Support\Str;
use Joserick\LaravelLivewireDiscover\Exceptions\ComponentNotFoundException;
use Livewire\Exceptions\ComponentNotFoundException as LivewireComponentNotFoundException;
use Livewire\Mechanisms\ComponentRegistry;

class LaravelLivewireDiscoverComponentRegistry extends ComponentRegistry
{
    function new($nameOrClass, $id = null)
    {
        $component = parent::new($nameOrClass, $id);

        $component->updateNameFromPrefix();

        return $component;
    }

    protected function getNameAndClass($nameComponentOrClass)
    {
        $name_class = $this->getNameAndClassDiscovered($nameComponentOrClass,
            app(LaravelLivewireDiscover::class)->getClassNamespaces()->getIterator());

        config(['livewire.class_namespace' => app(LaravelLivewireDiscover::class)->getClassNamespace()]);

        return $name_class;
    }

    private function getNameAndClassDiscovered($nameComponentOrClass, ArrayIterator $class_namespaces)
    {
        try {
            return parent::getNameAndClass($nameComponentOrClass);
        } catch (LivewireComponentNotFoundException $th) {
            if ($class_namespaces->valid()) {
                if (Str::startsWith($nameComponentOrClass, $class_namespaces->key())) {
                    $nameComponentOrClass = Str::replaceFirst($class_namespaces->key().'-', '', $nameComponentOrClass);
                }
                config(['livewire.class_namespace' => $class_namespaces->current()]);
                $class_namespaces->next();
            } else {
                throw new ComponentNotFoundException($class_namespaces->getArrayCopy(), $th);
            }

            return $this->getNameAndClassDiscovered($nameComponentOrClass, $class_namespaces);
        }
    }
}
