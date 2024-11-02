<?php

namespace Joserick\LaravelLivewireDiscover\Commands;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;
use Livewire\Features\SupportConsoleCommands\Commands\ComponentParser;
use Livewire\Features\SupportConsoleCommands\Commands\MakeCommand as LivewireMakeCommand;
use ReflectionClass;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'livewire-discover:make')]
class MakeCommand extends LivewireMakeCommand
{
    protected $signature = 'livewire-discover:make {name} {--prefix= : The prefix to use} {--force} {--inline} {--test} {--pest} {--stub= : If you have several stubs, stored in subfolders }';

    protected $description = 'Create a new Livewire Discover component';

    protected Collection $class_namespaces;

    protected ReflectionClass $ref_class;

    protected string $class_path;

    protected ?string $view_path = null;

    public function handle()
    {
        $this->class_namespaces = LaravelLivewireDiscover::getClassNamespaces();

        if ($this->class_namespaces->isEmpty()) {
            $this->error('There are no Livewire-Discover prefixes defined.');

            return;
        }

        $prefix = $this->option('prefix') ?? $this->choice('Select the prefix to use', $this->class_namespaces->keys()->toArray());

        if ($this->class_namespaces[$prefix]['class_path']) {
            $this->class_path = $this->class_namespaces[$prefix]['class_path'];
        } else {
            $this->error("There is no class path defined for the prefix $prefix");

            return;
        }

        config(['livewire.class_namespace' => $this->class_namespaces[$prefix]['class_namespace']]);

        if ($this->class_namespaces[$prefix]['view_path']) {
            $this->view_path = $this->class_namespaces[$prefix]['view_path'];
        } else {
            $this->input->setOption('inline', true);
        }

        $this->ref_class = new ReflectionClass(ComponentParser::class);

        parent::handle();
    }

    protected function createClass($force = false, $inline = false)
    {
        $base_class_path = $this->ref_class->getProperty('baseClassPath');
        $base_class_path->setAccessible(true);
        $base_class_path->setValue($this->parser, $this->class_path);

        return parent::createClass($force, $inline);
    }

    protected function createView($force = false, $inline = false)
    {
        if ($this->view_path) {
            $base_class_path = $this->ref_class->getProperty('baseViewPath');
            $base_class_path->setAccessible(true);
            $base_class_path->setValue($this->parser, $this->view_path);
        }

        return parent::createView($force, $inline);
    }

    public function isFirstTimeMakingAComponent()
    {
        foreach ($this->class_namespaces as $data) {
            if ($data['class_path'] && File::isDirectory($data['class_path'])) {
                return false;
            }
        }

        return true;
    }

    public function writeWelcomeMessage()
    {
        $asciiLogo = <<<EOT
            <fg=cyan> _     _                    _            ____  _</>
            <fg=cyan>| |   (_)_   _______      _(_)_ __ ___  |  _ \(_)___  ___ _____   _____ _ __</>
            <fg=cyan>| |   | \ \ / / _ \ \ /\ / / | '__/ _ \ | | | | / __|/ __/ _ \ \ / / _ \ '__|</>
            <fg=cyan>| |___| |\ V /  __/\ V  V /| | | |  __/ | |_| | \__ \ (_| (_) \ V /  __/ |</>
            <fg=cyan>|_____|_| \_/ \___| \_/\_/ |_|_|  \___| |____/|_|___/\___\___/ \_/ \___|_|</>
            EOT;
        $this->line("\n".$asciiLogo."\n");
        $this->line("\n<options=bold>Congratulations, you've created your first Livewire Discover component!</> 🎉🎉🎉\n");
    }
}
