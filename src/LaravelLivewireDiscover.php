<?php

namespace Joserick\LaravelLivewireDiscover;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void add($prefix, $namespace, $class_path = null, $view_path = null)
 * @method static \Illuminate\Support\Collection getClassNamespaces()
 * @method static void clean()
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
