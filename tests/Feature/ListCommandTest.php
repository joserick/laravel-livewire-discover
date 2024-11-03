<?php

use Illuminate\Support\Facades\File;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;

it('should display an error when there are no Livewire-Discover prefixes defined', function () {
    LaravelLivewireDiscover::shouldReceive('getClassNamespaces')
        ->once()
        ->andReturn(collect());

    $this->artisan('livewire-discover:list')
        ->expectsOutput('There are no Livewire-Discover prefixes defined.')
        ->assertExitCode(0);
});

it('should list Livewire Discover components', function () {
    LaravelLivewireDiscover::shouldReceive('getClassNamespaces')
        ->once()
        ->andReturn($this->CLASS_NAMESPACES);

    File::shouldReceive('isDirectory')
        ->once()
        ->andReturn(true);

    File::shouldReceive('allFiles')
        ->once()
        ->with($this->NAMESPACE_PATH)
        ->andReturn([
            new SplFileInfo(app_path('Tests/Components/TestComponent.php')),
        ]);

    $this->artisan('livewire-discover:list')
        ->expectsOutput('Livewire-Discover namespaces list:')
        ->expectsTable(
            ['Alias', 'Path'],
            [
                [
                    $this->PREFIX.'.components.test-component',
                    'app/Tests/Components/TestComponent.php',
                ],
            ]
        )
        ->assertExitCode(0);
});
