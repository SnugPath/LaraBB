<?php
namespace App\Helpers;

use Exception;

class Sidebar {

    private static array $items = [];

    /**
     * @throws Exception
     */
    public static function addSection(string $name, int $priority = 99, bool $returnSection = true): Sidebar|Section {

        if (array_key_exists($name, self::$items)) {
            throw new Exception("Section $name already exists!");
        }

        self::$items[$name] = new Section($priority);

        if (!$returnSection) {
            return new self();
        }

        return self::$items[$name];
    }

    public static function getSection(string $name): Section|null {
        if (!array_key_exists($name, self::$items)) {
            return null;
        }

        return self::$items[$name];
    }

    public static function render(): array {
        return self::$items;
    }

}
