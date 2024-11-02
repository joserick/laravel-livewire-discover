<?php

use Illuminate\Support\Facades\File;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;

it('executes livewire-discover:make command', function () {
    File::shouldReceive('put')->andReturn(true);
    File::shouldReceive('exists')->andReturn(false);
    File::shouldReceive('isDirectory')->andReturn(true);

    LaravelLivewireDiscover::add($this->PREFIX, $this->NAMESPACE, $this->CLASS_PATH);

    $this->artisan('livewire-discover:make TestsComponents.TestComponent --prefix='.$this->PREFIX)
        ->expectsOutputToContain('COMPONENT CREATED');

    LaravelLivewireDiscover::clean();
});
