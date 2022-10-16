<?php

namespace App\Helpers\Classes;

class Hooks
{

    protected static array $events = array();

    public static function add(string $name, callable|string $callback): void
    {
        if (!isset(self::$events[$name])) self::$events[$name] = array();
        self::$events[$name][] = $callback;
    }

    public static function trigger(string $name, $data = null): void
    {
        if (!isset(self::$events[$name])) return;
        foreach (self::$events[$name] as $callback) {
            $callback($name, $data);
        }
        self::remove($name);
    }

    public static function remove(string $name): void
    {
        unset(self::$events[$name]);
    }

}
