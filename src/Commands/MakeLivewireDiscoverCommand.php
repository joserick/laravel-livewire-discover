<?php

namespace Joserick\LaravelLivewireDiscover\Commands;

class MakeLivewireDiscoverCommand extends MakeDiscoverCommand
{
    protected $signature = 'make:livewire-discover {name} {--prefix= : The prefix to use} {--force} {--inline} {--test} {--pest} {--stub= : If you have several stubs, stored in subfolders }';
}
