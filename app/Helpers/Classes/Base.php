<?php

namespace App\Helpers\Classes;

use App\Helpers\Classes\AdminMenu\Menu;
use App\Helpers\Classes\AdminMenu\Section;
use App\Helpers\Classes\AdminMenu\Sidebar;
use App\Helpers\Core;
use Exception;

/**
 * Base class for plugins and themes. It is an abstract helper class for developers, with pre-made functions for
 * optimization and more intuitive flow when developing themes and plugins.
 */
abstract class Base
{

    /**
     * This init method will be called by LaraBB when the plugin/theme is loaded.
     * @return void
     */
    abstract public static function onLoad(): void;

    /**
     * The onActivate method will be called every time the plugin/theme is activated.
     * @return void
     */
    abstract public static function onActivate(): void;

    /**
     * The onUpdate method will be called every time the plugin/theme is updated.
     * @return void
     */
    abstract public static function onUpdate(): void;

    /**
     * The onDeactivate method will be called every time the plugin/theme is deactivated.
     * @return void
     */
    abstract public static function onDeactivate(): void;

    /**
     * The addHook method is a quick and intuitive function to add a hook
     * @param string $name The hook name
     * @param callable|string $callback The function that will be called when the hook is called
     * @return void
     */
    protected static function addHook(string $name, callable|string $callback): void
    {
        Core::$hook->add($name, $callback);
    }

    /**
     * The removeHook method is a quick and intuitive function to remove a hook.
     * @param string $name The hook name
     * @return void
     */
    protected static function removeHook(string $name): void
    {
        Core::$hook->remove($name);
    }

    /**
     * Get a specific section filtered by its name
     * @param string $name Section name
     * @return Section|null
     */
    protected static function getSection(string $name): Section|null
    {
        return Core::$sidebar->getSection($name);
    }

    /**
     * Add a section to the side menu of the Admin Dashboard
     * @param string $name Section name
     * @param int $priority Priority of section: Default: 99
     * @param bool $returnSection If is true, return the created Section, otherwise return the Sidebar
     * @return Section|Sidebar
     * @throws Exception
     */
    protected static function addSection(string $name, int $priority = 99, bool $returnSection = true): Section|Sidebar
    {
        return Core::$sidebar->addSection($name, $priority, $returnSection);
    }

    /** Get a specific menu filtered by Section name and its name
     * @param string $sectionName Section name
     * @param string $menuName Menu name
     * @return Menu
     */
    protected static function getMenu(string $sectionName, string $menuName): Menu
    {
        return self::getSection($sectionName)->getMenu($menuName);
    }

    /** Add a menu to a specific section
     * @param string $sectionName Section name
     * @param string $menuName Menu name
     * @param int $priority Priority of menu: Default: 99
     * @param string|false $path Path of the route to which this menu will redirect.
     * If it does not contain path or will have submenus, it must be filled with false.
     * @param bool $returnMenu
     * @return Section|Menu If is true, return the created Menu, otherwise return the Section
     * @throws Exception
     */
    protected static function addMenu(
        string $sectionName,
        string $menuName,
        int $priority = 99,
        string|false $path = false,
        bool $returnMenu = true
    ): Section|Menu
    {
        return self::getSection($sectionName)->addMenu($menuName, $priority, $path, $returnMenu);
    }

    /**
     * Add a submenu to a specific menu
     * @param string $sectionName Section name
     * @param string $menuName Menu name
     * @param string $submenuName Submenu name
     * @param int $priority Priority of submenu: Default: 99
     * @param string $path Path of the route to which this menu will redirect.
     * @return Menu
     * @throws Exception
     */
    protected static function addSubmenu(
        string $sectionName,
        string $menuName,
        string $submenuName,
        int $priority = 99,
        string $path = ''
    ): Menu
    {
        return self::getMenu($sectionName, $menuName)->addSubmenu($submenuName, $priority, $path);
    }

}
