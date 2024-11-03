<?php

use Illuminate\Support\Facades\File;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;

it('executes livewire-discover:make command', function () {
    File::shouldReceive('put')->andReturn(true);
    File::shouldReceive('exists')->andReturn(false);
    File::shouldReceive('isDirectory')->andReturn(true);

    LaravelLivewireDiscover::shouldReceive('getClassNamespaces')
        ->once()
        ->andReturn($this->CLASS_NAMESPACES);

    $this->artisan('livewire-discover:make TestsComponents.TestComponent --prefix='.$this->PREFIX)
        ->expectsOutputToContain('COMPONENT CREATED');
});
