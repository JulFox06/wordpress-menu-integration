<?php

namespace Jrenard\Src\Supports;

class Debug
{
    /**
     * Dump the passed variables and wrapping it with <pre> tag if not in CLI mode.
     */
    public static function dump(mixed ...$data): void
    {
        $sapiName = PHP_SAPI;

        echo $sapiName !== 'cli' ? '<pre>' : '';
        var_dump(...$data);
        echo $sapiName !== 'cli' ? '</pre>' : '';
    }

    /**
     * Dump the passed variables and die.
     */
    public static function dumpAndDie(mixed ...$data): void
    {
        self::dump(...$data);
        die();
    }
}
