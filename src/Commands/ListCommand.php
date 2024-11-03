<?php

namespace Joserick\LaravelLivewireDiscover\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Joserick\LaravelLivewireDiscover\LaravelLivewireDiscover;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'livewire-discover:list')]
class ListCommand extends Command
{
    use ToolCommand;

    protected $signature = 'livewire-discover:list';

    protected $description = 'List all Livewire Discover components';

    public function handle()
    {
        $class_namespaces = LaravelLivewireDiscover::getClassNamespaces();

        if ($class_namespaces->isEmpty()) {
            $this->error('There are no Livewire-Discover prefixes defined.');

            return;
        }

        $this->info('Livewire-Discover namespaces list:');

        foreach ($class_namespaces as $prefix => $class_namespace) {
            $this->newLine();
            $this->info("Prefix: '$prefix' ({$class_namespace['class_namespace']})");

            if ($class_namespace['class_path']) {
                $path = $class_namespace['class_path'];
            } else {
                $path = $this->getClassPathFromNamespace($class_namespace['class_namespace'], $prefix);
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
                ['Alias', 'Path'],
                collect($phpFiles)->map(function ($file) use ($prefix, $path) {
                    return [
                        $prefix.'.'.str($file->getPathname())
                            ->after($path)
                            ->ltrim(DIRECTORY_SEPARATOR)
                            ->before('.php')
                            ->explode(DIRECTORY_SEPARATOR)
                            ->map(fn ($segment) => str($segment)->kebab())
                            ->join('.'),
                        str($file->getPathname())
                            ->after(base_path())
                            ->ltrim(DIRECTORY_SEPARATOR),
                    ];
                })
            );
        }
    }
}
