<?php

namespace Jrenard\Src\Supports;

class Str
{
    /**
     * Convert a string to kebab-case.
     */
    public static function toKebabCase(string $content): string
    {
        return _wp_to_kebab_case($content);
    }

    /**
     * Convert a string to snake_case.
     */
    public static function toSnakeCase(string $content): string
    {
        return str_replace('-', '_', self::toKebabCase($content));
    }
}
