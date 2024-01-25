<?php

namespace Joserick\LaravelLivewireDiscover\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelLivewireDiscover extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-livewire-discover';
    }
}
