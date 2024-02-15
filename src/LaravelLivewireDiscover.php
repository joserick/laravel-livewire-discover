<?php

namespace Joserick\LaravelLivewireDiscover;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void add($prefix, $namespace)
 * @method static string getClassNamespace()
 * @method static \Illuminate\Support\Collection getClassNamespaces()
 * @method static string|bool getPrefixFromClass($class)
 * @method static string|bool getAliasFormClass($class)
 * @method static string|bool getClassFromNameWithNamespace($nameComponent)
 *
 * @see \Joserick\LaravelLivewireDiscover\LaravelLivewireDiscoverData
 */

class LaravelLivewireDiscover extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-livewire-discover';
    }
}
