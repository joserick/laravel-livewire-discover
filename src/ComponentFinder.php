<?php

namespace Joserick\LaravelLivewireDiscover;

use Livewire\Finder\Finder as LivewireFinder;

class ComponentFinder extends LivewireFinder
{
    protected function generateNameFromClass($class): string
    {
        return ComponentResolver::getAliasFromClass($class,
            fn ($class) => parent::generateNameFromClass($class));
    }

    protected function generateClassFromName($name, $classNamespaces = []): string
    {
        return ComponentResolver::getClassFromAlias($name) ?:
            parent::generateClassFromName($name);
    }
}
