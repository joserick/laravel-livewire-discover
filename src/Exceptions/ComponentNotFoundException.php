<?php

namespace Joserick\LaravelLivewireDiscover\Exceptions;

use Livewire\Exceptions\ComponentNotFoundException as LivewireComponentNotFoundException;

class ComponentNotFoundException extends LivewireComponentNotFoundException
{
    public function __construct(array $prefixes, LivewireComponentNotFoundException $previous = null) {
        parent::__construct('(Also in the prefixes paths: '.implode(', ', array_keys($prefixes)).') '
        . $previous->getMessage(), 0, $previous);
    }
}
