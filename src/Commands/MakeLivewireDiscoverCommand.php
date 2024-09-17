<?php

namespace Joserick\LaravelLivewireDiscover\Commands;

class MakeLivewireDiscoverCommand extends MakeDiscoverCommand
{
    protected $signature = 'make:livewire-discover {name} {--force} {--inline} {--test} {--pest} {--stub=}';
}
