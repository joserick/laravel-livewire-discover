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
    $classNamespaces = collect([
        'app-livewire' => [
            'class_namespace' => 'App\\Livewire',
            'class_path' => base_path('app/Livewire')
        ]
    ]);

    LaravelLivewireDiscover::shouldReceive('getClassNamespaces')
        ->once()
        ->andReturn($classNamespaces);

    File::shouldReceive('isDirectory')
        ->once()
        ->andReturn(true);

    File::shouldReceive('allFiles')
        ->once()
        ->with(base_path('app/Livewire'))
        ->andReturn([
            new SplFileInfo(base_path('app/Livewire/ExampleComponent.php'))
        ]);

    $this->artisan('livewire-discover:list')
    ->expectsOutput('List of Livewire Discover components:')
    ->expectsTable(
        ['Alias', 'Paths'],
        [
            ['app-livewire.example-component', base_path('app/Livewire/ExampleComponent.php')]
        ]
    )
    ->assertExitCode(0);
});
