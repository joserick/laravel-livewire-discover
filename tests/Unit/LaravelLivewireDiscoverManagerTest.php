<?php

use Joserick\LaravelLivewireDiscover\ComponentResolver;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;
use Livewire\Livewire;

afterEach(function () {
    $class = ComponentResolver::resolve($this->ALIAS);
    LaravelLivewireDiscover::clean();
    expect($this->CLASS)->toBe($class);
});

it('add namespace and prefix through component-namespace', function () {
    Livewire::componentNamespace($this->NAMESPACE, $this->PREFIX);
});

it('add prefix and namespace through discover', function () {
    Livewire::discover($this->PREFIX, $this->NAMESPACE);
});

it('add prefix, namespace and class path through discover', function () {
    Livewire::discover($this->PREFIX, $this->NAMESPACE, $this->CLASS_PATH);
});

it('add prefix, namespace and class path through discovers', function () {
    Livewire::discovers([
        $this->PREFIX => [$this->NAMESPACE, $this->CLASS_PATH],
    ]);
});
