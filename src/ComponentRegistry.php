<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\Mechanisms\ComponentRegistry as LivewireComponentRegistry;

class ComponentRegistry extends LivewireComponentRegistry
{
    protected function generateNameFromClass($class)
    {
        if ($alias = ComponentResolver::getAliasFromClass($class)){
            return $alias;
        }

        return parent::generateNameFromClass($class);
    }
}
