<?php

namespace App\Helpers\Interfaces;

use App\Helpers\Classes\AdminMenu\Section;
use App\Helpers\Classes\AdminMenu\Sidebar;
use App\Helpers\Core;
use Exception;

/**
 *
 */
abstract class Base
{

    /**
     * This init method will be called by LaraBB when the plugin/theme is loaded.
     * @return void
     */
    abstract public static function OnLoad(): void;

    /**
     * @return void
     */
    abstract public static function OnActivate(): void;

    /**
     * @return void
     */
    abstract public static function OnUpdate(): void;

    /**
     * @return void
     */
    abstract public static function OnDeactivation(): void;

    /**
     * @param string $name
     * @param callable|string $callback
     * @return void
     */
    private function AddHook(string $name, callable|string $callback): void
    {
        Core::$hook->add($name, $callback);
    }

    /**
     * @param string $name
     * @return void
     */
    private function RemoveHook(string $name): void
    {
        Core::$hook->remove($name);
    }

    /**
     * @param string $name
     * @param int $priority
     * @param bool $returnSection
     * @return Section|Sidebar
     * @throws Exception
     */
    private function AddSection(string $name, int $priority = 99, bool $returnSection = true): Section|Sidebar
    {
        return Core::$sidebar->addSection($name, $priority, $returnSection);
    }

    /**
     * @param string $name
     * @return Section|null
     */
    private function GetSection(string $name): Section|null
    {
        return Core::$sidebar->getSection($name);
    }

}
