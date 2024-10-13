<?php

namespace Joserick\LaravelLivewireDiscover;

class ComponentResolver
{
    /**
     * Get the prefix from the class.
     */
    public static function getPrefixFromClass(string $class): string|bool
    {
        foreach (LaravelLivewireDiscover::getClassNamespaces() as $prefix => $class_namespace) {
            if (is_array($class_namespace)) {
                $class_namespace = $class_namespace['class_namespace'];
            }

            if (str($class)->startsWith($class_namespace)) {
                return $prefix;
            }
        }

        return false;
    }

    /**
     * Get the alias from the class.
     */
    public static function getAliasFromClass(string $class): string|bool
    {
        if ($prefix = self::getPrefixFromClass($class)) {
            return $prefix.'.'.str(substr(strrchr($class, '\\'), 1))->kebab();
        }

        return false;
    }

    /**
     * Get the class from the name component.
     */
    public static function getClassFromNameComponent(string $name_component): string|bool
    {
        $class = collect(str($name_component)->explode('.'))
            ->map(fn ($segment) => (string) str($segment)->studly())
            ->join('\\');

        return class_exists($class) ? $class : false;
    }

    /**
     * Get the class from the alias.
     */
    public static function getClassFromAlias(string $alias): string|bool
    {
        foreach (LaravelLivewireDiscover::getClassNamespaces() as $prefix => $class_namespace) {
            if (is_array($class_namespace)) {
                $class_namespace = $class_namespace['class_namespace'];
            }

            if (str($alias)->startsWith($prefix)) {
                $class = $class_namespace.'\\'.Str::studly(substr($alias, strlen($prefix) + 1));
                if (str($class)->contains('.')) {
                    return self::getClassFromNameComponent($class);
                }

                return class_exists($class) ? $class : false;
            }
        }

        return false;
    }

    /**
     * Resolve the class from alias or name component.
     */
    public static function resolve(string &$alias_or_name_component): string|bool
    {
        if ($class = self::getClassFromAlias($alias_or_name_component)) {
            return $class;
        }

        if ($class = self::getClassFromNameComponent($alias_or_name_component)) {
            $alias_or_name_component = self::getAliasFromClass($class);

            return $class;
        }

        return false;
    }
}
