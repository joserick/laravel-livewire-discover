<?php

use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;
use Livewire\Finder\Finder;
use Livewire\LivewireManager;

it('should run the command install', function () {
    $this->artisan('livewire-discover:install')
        ->expectsConfirmation('Would you like to star our repo on GitHub?')
        ->assertExitCode(0);
});

it('generates alias from class', function () {
    LaravelLivewireDiscover::shouldReceive('getClassNamespaces')
        ->andReturn($this->CLASS_NAMESPACES);

    $finder = app(Finder::class);
    $manager = app(LivewireManager::class);

    $class = $finder->resolveClassComponentClassName($this->ALIAS);
    $alias = $finder->normalizeName($this->CLASS);
    $discoverable = $manager->exists(new $this->CLASS);

    expect($alias)->toBe($this->ALIAS)
        ->and($class)->toBe($this->CLASS)
        ->and($discoverable)->toBeTrue();
});
