<?php

namespace Joserick\LaravelLivewireDiscover;

use Illuminate\Support\Str;

class ComponentResolver
{
    /**
     * Get the prefix from the class.
     *
     * @param  string  $class
     * @return string|bool
     */
    public static function getPrefixFromClass(string $class) : string|bool
    {
        foreach (LaravelLivewireDiscover::getClassNamespaces() as $prefix => $class_namespace) {
            if (is_array($class_namespace)) {
                $class_namespace = $class_namespace['class_namespace'];
            }

            if (Str::startsWith($class, $class_namespace)) {
                return $prefix;
            }
        }

        return false;
    }

    /**
     * Get the alias form class.
     *
     * @param  string  $class
     * @return string|bool
     */
    public static function getAliasFromClass(string $class) : string|bool
    {
        if ($prefix = self::getPrefixFromClass($class)) {
            return $prefix.'.'.str(substr(strrchr($class, '\\'), 1))->kebab();
        }

        return $prefix;
    }

    /**
     * Get the class from class_namespace.
     *
     * @param  string  $nameComponent
     * @return string|bool
     */
    public static function getClassFromNameComponent(string $name_component) : string|bool
    {
        $class = collect(str($name_component)->explode('.'))
            ->map(fn ($segment) => (string) str($segment)->studly())
            ->join('\\');

        if (class_exists($class)) {
            return $class;
        }

        return false;
    }

    /**
     * Get the class from alias.
     *
     * @param  string  $alias
     * @return string|bool
     */
    public static function getClassFromAlias(string $alias) : string|bool
    {
        foreach (LaravelLivewireDiscover::getClassNamespaces() as $prefix => $class_namespace) {
            if (is_array($class_namespace)) {
                $class_namespace = $class_namespace['class_namespace'];
            }

            if (Str::startsWith($alias, $prefix)) {
                $class = $class_namespace . '\\' . Str::studly(substr($alias, strlen($prefix) + 1));
                if (Str::contains($class, '.')) {
                    return self::getClassFromNameComponent($class);
                }

                if (class_exists($class)) {
                    return $class;
                }
            }
        }

        return false;
    }

    /**
     * Resolve the class from alias or name component.
     *
     * @param  string  $alias
     * @return string|bool
     */
    public static function resolve(string &$alias_or_name_component)
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
