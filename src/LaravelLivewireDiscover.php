<?php

namespace Joserick\LaravelLivewireDiscover;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void add($prefix, $namespace)
 * @method static \Illuminate\Support\Collection getClassNamespaces()
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
