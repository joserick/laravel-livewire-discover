<?php

namespace Joserick\LaravelLivewireDiscover\Commands;

use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;
use Livewire\Features\SupportConsoleCommands\Commands\ComponentParser;
use Livewire\Features\SupportConsoleCommands\Commands\MakeCommand;
use ReflectionClass;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'livewire-discover:make')]
class MakeDiscoverCommand extends MakeCommand
{
    protected $signature = 'livewire-discover:make {name} {--prefix= : The prefix to use} {--force} {--inline} {--test} {--pest} {--stub= : If you have several stubs, stored in subfolders }';

    protected $description = 'Create a new Livewire Discover component';

    protected $class_path;

    public function handle()
    {
        $class_namespaces = LaravelLivewireDiscover::getClassNamespaces();

        if ($class_namespaces->isEmpty()) {
            $this->error('There are no Livewire-Discover prefixes defined.');

            return;
        }

        $prefix = $this->option('prefix') ?? $this->choice('Select the prefix to use', $class_namespaces->keys()->toArray());

        if ($class_namespaces[$prefix]['class_path']) {
            $this->class_path = $class_namespaces[$prefix]['class_path'];
        } else {
            $this->error("There is no class path defined for the prefix $prefix");

            return;
        }

        config(['livewire.class_namespace' => $class_namespaces[$prefix]['class_namespace']]);

        $this->input->setOption('inline', true);

        parent::handle();
    }

    protected function createClass($force = false, $inline = false)
    {
        $refClass = new ReflectionClass(ComponentParser::class);
        $baseClassPath = $refClass->getProperty('baseClassPath');
        $baseClassPath->setAccessible(true);
        $baseClassPath->setValue($this->parser, $this->class_path);

        return parent::createClass($force, $inline);
    }
}
