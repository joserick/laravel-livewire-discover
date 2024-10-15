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
