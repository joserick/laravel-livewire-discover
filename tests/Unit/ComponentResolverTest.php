<?php

use Joserick\LaravelLivewireDiscover\ComponentResolver;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;

beforeEach(function () {
    LaravelLivewireDiscover::add($this->PREFIX, $this->NAMESPACE);
});

afterEach(function () {
    LaravelLivewireDiscover::clean();
});

it('gets the prefix from the class', function () {
    [$prefix, $namespace] = ComponentResolver::getPrefixAndNamespaceFromClass($this->CLASS);
    expect($prefix)->toBe($this->PREFIX);
    expect($namespace)->toBe($this->NAMESPACE);
});

it('gets the class from the alias', function () {
    $class = ComponentResolver::getClassFromAlias($this->ALIAS);
    expect($class)->toBe($this->CLASS);
});

it('restores the original namespace after getting alias from class', function () {
    // Store the original namespace that Livewire uses by default
    $originalNamespace = 'App\\Livewire';
    config(['livewire.class_namespace' => $originalNamespace]);
    
    // Call getAliasFromClass with a prefixed component
    // This should temporarily change the namespace, then restore it
    $alias = ComponentResolver::getAliasFromClass(
        $this->CLASS,
        fn($class) => 'test-component'
    );
    
    // After the method completes, the original namespace should be restored
    expect(config('livewire.class_namespace'))->toBe($originalNamespace);
    expect($alias)->toBe($this->PREFIX.'.test-component');
});
