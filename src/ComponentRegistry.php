<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\Mechanisms\ComponentRegistry as LivewireComponentRegistry;

class ComponentRegistry extends LivewireComponentRegistry
{
    protected function generateNameFromClass($class)
    {
        return ComponentResolver::getAliasFromClass($class,
            fn ($class) => parent::generateNameFromClass($class));
    }

    protected function generateClassFromName($name)
    {
        return ComponentResolver::getClassFromAlias($name) ?:
            parent::generateClassFromName($name);
    }
}
