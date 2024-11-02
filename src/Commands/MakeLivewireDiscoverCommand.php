<?php

namespace Joserick\LaravelLivewireDiscover\Commands;

use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:livewire-discover')]
class MakeLivewireDiscoverCommand extends MakeCommand
{
    protected $signature = 'make:livewire-discover {name} {--prefix= : The prefix to use} {--force} {--inline} {--test} {--pest} {--stub= : If you have several stubs, stored in subfolders }';
}
