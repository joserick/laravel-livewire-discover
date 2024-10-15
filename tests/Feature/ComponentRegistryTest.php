<?php

use Livewire\Mechanisms\ComponentRegistry;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;

it('generates alias from class', function () {
    LaravelLivewireDiscover::add($this->PREFIX, $this->NAMESPACE);

    $registry = $this->app->make(ComponentRegistry::class);

    $class = $registry->getClass($this->ALIAS);
    $alias = $registry->getName($this->CLASS);
    $discoverable = $registry->isDiscoverable(new $this->CLASS);

    LaravelLivewireDiscover::clean();

    expect($alias)->toBe($this->ALIAS);
    expect($class)->toBe($this->CLASS);
    expect($discoverable)->toBeTrue();
});
