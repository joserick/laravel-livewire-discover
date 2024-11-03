<?php

namespace Joserick\LaravelLivewireDiscover\Commands;

use Composer\Autoload\ClassLoader;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'livewire-discover:list')]
class ListCommand extends Command
{
    protected $signature = 'livewire-discover:list';

    protected $description = 'List all Livewire Discover components';

    protected array $prefixes;

    public function handle()
    {
        $class_namespaces = LaravelLivewireDiscover::getClassNamespaces();

        if ($class_namespaces->isEmpty()) {
            $this->error('There are no Livewire-Discover prefixes defined.');

            return;
        }

        $composerClassLoader = null;
        foreach (spl_autoload_functions() as $function) {
            if (is_array($function) && $function[0] instanceof ClassLoader) {
                $composerClassLoader = $function[0];
                break;
            }
        }

        if (! $composerClassLoader) {
            $this->error('Composer ClassLoader not found.');

            return;
        }

        $this->prefixes = $composerClassLoader->getPrefixesPsr4();

        $this->info('Livewire-Discover namespaces list:');

        foreach ($class_namespaces as $prefix => $class_namespace) {
            $this->newLine();
            $this->info("Prefix: '$prefix' ({$class_namespace['class_namespace']})");

            if (isset($class_namespace['class_path'])) {
                $path = $class_namespace['class_path'];
            } else {
                $this->warn("There is no \"class path\" defined for the config for prefix \"$prefix\"");
                $this->comment('Getting the "class path" from the composer autoload file');
                $path = $this->getClassPathFromNamespace($class_namespace['class_namespace']);
            }

            if (! $path) {
                $this->error("Not found the \"class path\" in the composer autoload file for the namespace {$class_namespace['class_namespace']}");

                continue;
            }

            if (! File::isDirectory($path)) {
                $this->error("The directory $path of '{$class_namespace['class_namespace']}' does not exist or is not a directory.");

                continue;
            }

            $phpFiles = array_filter(File::allFiles($path), function ($file) {
                return $file->getExtension() === 'php';
            });

            if (empty($phpFiles)) {
                $this->warn("There are no Class files in the directory $path of '{$class_namespace['class_namespace']}'");

                continue;
            }

            $this->table(
                ['Alias', 'Paths'],
                collect($phpFiles)->map(function ($file) use ($prefix, $path) {
                    return [
                        $prefix.'.'.str($file->getPathname())
                            ->after($path)
                            ->ltrim(DIRECTORY_SEPARATOR)
                            ->before('.php')
                            ->explode(DIRECTORY_SEPARATOR)
                            ->map(fn ($segment) => str($segment)->kebab())
                            ->join('.'),
                        $file->getPathname(),
                    ];
                })
            );
        }
    }

    protected function getClassPathFromNamespace(string $namespace): ?string
    {
        foreach ($this->prefixes as $prefix => $dirs) {
            if (strpos($namespace, $prefix) === 0) {
                $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, substr($namespace, strlen($prefix)));

                return realpath(rtrim($dirs[0], DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$relativePath);
            }
        }

        return null;
    }
}
