<?php

use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;
use Livewire\Mechanisms\ComponentRegistry;

it('should run the command install', function () {
    $this->artisan('livewire-discover:install')
        ->expectsConfirmation('Would you like to star our repo on GitHub?')
        ->assertExitCode(0);
});

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
