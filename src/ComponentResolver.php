<?php

namespace Joserick\LaravelLivewireDiscover;

class ComponentResolver
{
    /**
     * Get the prefix and namespace from the class.
     */
    public static function getPrefixAndNamespaceFromClass(string $class): array|bool
    {
        foreach (LaravelLivewireDiscover::getClassNamespaces() as $prefix => $data) {
            if (str($class)->startsWith($data['class_namespace'])) {
                return [$prefix, $data['class_namespace']];
            }
        }

        return false;
    }

    /**
     * Get the alias from the class.
     */
    public static function getAliasFromClass(string $class, callable $generate_name_from_class): string
    {
        if ([$prefix, $namespace] = self::getPrefixAndNamespaceFromClass($class)) {
            $original_namespace = config('livewire.class_namespace');

            config(['livewire.class_namespace' => $namespace]);
            $alias = $prefix.'.'.$generate_name_from_class($class);

            config(['livewire.class_namespace', $original_namespace]);

            return $alias;
        }

        return $generate_name_from_class($class);
    }

    /**
     * Get the class from the alias.
     */
    public static function getClassFromAlias(string $alias): string|bool
    {
        foreach (LaravelLivewireDiscover::getClassNamespaces() as $prefix => $data) {
            if (str($alias)->startsWith($prefix)) {
                $class = self::dotNotationToNamespacePath(
                    $data['class_namespace'].'\\'.str($alias)->substr(strlen($prefix) + 1)->studly()
                );

                return class_exists($class) ? $class : false;
            }
        }

        return false;
    }

    /**
     * Resolve the class from alias.
     */
    public static function resolve(string $alias): string|bool
    {
        return self::getClassFromAlias($alias) ?: false;
    }

    /**
     * Convert dot notation to namespace path.
     */
    protected static function dotNotationToNamespacePath(string $name_component): string
    {
        return str($name_component)->explode('.')
            ->map(fn ($segment) => str($segment)->studly())
            ->join('\\');
    }
}
