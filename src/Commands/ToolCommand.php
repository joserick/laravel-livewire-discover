<?php

namespace Joserick\LaravelLivewireDiscover\Commands;

use Composer\Autoload\ClassLoader;

trait ToolCommand
{
    protected ?array $indexes = null;

    protected function getClassPathFromNamespace(string $namespace, $prefix): ?string
    {
        if (! $this->indexes) {
            $this->warn("There is no \"class path\" defined for the config for prefix \"$prefix\"");
            $this->comment('Getting the "class path" from the composer autoload file');
            $composerClassLoader = $this->getClassLoader();

            if (! $composerClassLoader) {
                $this->error('ClassLoader (composer autoload file) not found.');

                return null;
            }

            $this->indexes = $composerClassLoader->getPrefixesPsr4();
        }

        foreach ($this->indexes as $index => $dirs) {
            if (strpos($namespace, $index) === 0) {
                $relativePath = str_replace('\\', DIRECTORY_SEPARATOR, substr($namespace, strlen($index)));

                return realpath(rtrim($dirs[0],
                    DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$relativePath).DIRECTORY_SEPARATOR;
            }
        }

        return null;
    }

    protected function getClassLoader(): ?ClassLoader
    {
        foreach (spl_autoload_functions() as $function) {
            if (is_array($function) && $function[0] instanceof ClassLoader) {
                return $function[0];
            }
        }

        return null;
    }
}
